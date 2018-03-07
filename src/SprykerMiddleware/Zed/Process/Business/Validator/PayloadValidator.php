<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator;

use Generated\Shared\Transfer\ValidatorConfigTransfer;
use SprykerMiddleware\Shared\Process\Log\MiddlewareLoggerTrait;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface;
use SprykerMiddleware\Zed\Process\Business\Exception\InvalidItemException;
use SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\Resolver\ValidatorPluginResolverInterface;

class PayloadValidator implements PayloadValidatorInterface
{
    use MiddlewareLoggerTrait;

    const KEY_IS_VALID = 'isValid';
    const KEY_ITEM = 'item';
    const KEY_KEY = 'key';
    const KEY_OPTIONS = 'options';
    const KEY_VALIDATION_RULE = 'rule';
    const KEY_VALUE = 'value';
    const OPERATION = 'Validation';

    /**
     * @var \Generated\Shared\Transfer\ValidatorConfigTransfer
     */
    protected $validatorConfigTransfer;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\Resolver\ValidatorPluginResolverInterface
     */
    protected $validatorPluginResolver;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface
     */
    protected $arrayManager;

    /**
     * @param \Generated\Shared\Transfer\ValidatorConfigTransfer $validatorConfigTransfer
     * @param \SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\Resolver\ValidatorPluginResolverInterface $validatorPluginResolver
     * @param \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface $arrayManager
     */
    public function __construct(
        ValidatorConfigTransfer $validatorConfigTransfer,
        ValidatorPluginResolverInterface $validatorPluginResolver,
        ArrayManagerInterface $arrayManager
    ) {
        $this->validatorConfigTransfer = $validatorConfigTransfer;
        $this->validatorPluginResolver = $validatorPluginResolver;
        $this->arrayManager = $arrayManager;
    }

    /**
     * @param array $payload
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\InvalidItemException
     *
     * @return array
     */
    public function validate(array $payload): array
    {
        $isValid = true;
        foreach ($this->validatorConfigTransfer->getRules() as $key => $rules) {
            $isValid = $isValid && $this->validateKey($payload, $key, $rules);
        }

        if (!$isValid) {
            $this->getProcessLogger()->warning('Item is invalid. Processing of item is skipped', [
                static::KEY_ITEM => $payload,
            ]);
            throw new InvalidItemException("Item is invalid. Processing of item is skipped");
        }

        return $payload;
    }

    /**
     * @param array $payload
     * @param string $key
     * @param mixed $rules
     *
     * @return bool
     */
    protected function validateKey(array $payload, string $key, $rules): bool
    {
        if (!strstr($key, '*')) {
            return $this->validateByRuleSet($payload, $key, $rules);
        }

        return $this->validateNestedKeys($payload, $key, $rules);
    }

    /**
     * @param array $payload
     * @param string $key
     * @param mixed $rules
     *
     * @return bool
     */
    protected function validateByRuleSet(array $payload, string $key, $rules): bool
    {
        $isValid = true;
        if (!is_array($rules)) {
            $rules = [$rules];
        }
        foreach ($rules as $rule) {
            $isValid = $isValid && $this->validateByRule($payload, $key, $rule);
        }

        return $isValid;
    }

    /**
     * @param array $payload
     * @param string $key
     * @param mixed $rules
     *
     * @return bool
     */
    protected function validateNestedKeys(array $payload, string $key, $rules): bool
    {
        $isValid = true;
        $keys = $this->arrayManager->getAllNestedKeys($payload, $key);
        foreach ($keys as $key) {
            $isValid = $isValid && $this->validateByRuleSet($payload, $key, $rules);
        }

        return $isValid;
    }

    /**
     * @param array $payload
     * @param string $key
     * @param mixed $rule
     *
     * @return bool
     */
    protected function validateByRule(array $payload, string $key, $rule): bool
    {
        if (is_callable($rule)) {
            return $this->validateCallable($payload, $key, $rule);
        }

        return $this->validateValue($payload, $key, $rule);
    }

    /**
     * @param array $payload
     * @param string $key
     * @param callable $rule
     *
     * @return bool
     */
    protected function validateCallable(array $payload, string $key, callable $rule): bool
    {
        $inputValue = $this->arrayManager->getValueByKey($payload, $key);
        $isValid = $rule($inputValue, $key, $payload);

        $this->getProcessLogger()->debug(
            static::OPERATION,
            [
                static::KEY_KEY => $key,
                static::KEY_VALIDATION_RULE => $rule,
                static::KEY_VALUE => $inputValue,
                static::KEY_IS_VALID => $isValid,
            ]
        );

        return $isValid;
    }

    /**
     * @param array $payload
     * @param string $key
     * @param mixed $rule
     *
     * @return bool
     */
    protected function validateValue(array $payload, string $key, $rule): bool
    {
        if (!is_array($rule)) {
            $rule = [$rule];
        }
        $options = isset($rule[static::KEY_OPTIONS]) ? $rule[static::KEY_OPTIONS] : [];

        $validatorPlugin = $this->validatorPluginResolver
            ->getValidatorPluginByName(reset($rule));
        $inputValue = $this->arrayManager->getValueByKey($payload, $key);
        $isValid = $validatorPlugin->validate($inputValue, $payload, $key, $options);
        $this->getProcessLogger()->debug(
            static::OPERATION,
            [
                static::KEY_KEY => $key,
                static::KEY_VALIDATION_RULE => $rule,
                static::KEY_VALUE => $inputValue,
                static::KEY_IS_VALID => $isValid,
                static::KEY_OPTIONS => $options,
            ]
        );

        return $isValid;
    }
}
