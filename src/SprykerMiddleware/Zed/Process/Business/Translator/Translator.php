<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator;

use Generated\Shared\Transfer\TranslatorConfigTransfer;
use SprykerMiddleware\Shared\Process\Log\MiddlewareLoggerTrait;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionPluginResolverInterface;

class Translator implements TranslatorInterface
{
    use MiddlewareLoggerTrait;

    const OPERATION = 'Translation';

    const KEY_OPTIONS = 'options';
    const KEY_KEY = 'key';
    const KEY_OPERATION_TYPE = 'operation_type';
    const KEY_AFFECTED_DATA = 'affected_data';
    const KEY_RESULTED_DATA = 'resulted_data';

    /**
     * @var \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    protected $translatorConfigTransfer;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionPluginResolverInterface
     */
    protected $translatorFunctionResolver;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface
     */
    protected $arrayManager;

    /**
     * @param \Generated\Shared\Transfer\TranslatorConfigTransfer $translatorConfigTransfer
     * @param \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionPluginResolverInterface $translatorFunctionResolver
     * @param \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface $arrayManager
     */
    public function __construct(
        TranslatorConfigTransfer $translatorConfigTransfer,
        TranslatorFunctionPluginResolverInterface $translatorFunctionResolver,
        ArrayManagerInterface $arrayManager
    ) {
        $this->translatorConfigTransfer = $translatorConfigTransfer;
        $this->translatorFunctionResolver = $translatorFunctionResolver;
        $this->arrayManager = $arrayManager;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function translate(array $payload): array
    {
        $result = $payload;
        foreach ($this->translatorConfigTransfer->getDictionary() as $key => $translations) {
            $result = $this->translateKey($result, $payload, $key, $translations);
        }

        return $result;
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $translation
     *
     * @return array
     */
    protected function translateKey(array $result, array $payload, string $key, $translation): array
    {
        if (!strstr($key, '*')) {
            return $this->translateByRuleSet($result, $payload, $key, $translation);
        }

        return $this->translateNestedKeys($result, $payload, $key, $translation);
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $translation
     *
     * @return array
     */
    protected function translateByRuleSet(array $result, array $payload, string $key, $translation): array
    {
        if (is_array($translation)) {
            foreach ($translation as $rule) {
                $result = $this->translateByRule($result, $payload, $key, $rule);
            }
            return $result;
        }

        return $this->translateByRule($result, $payload, $key, $translation);
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $translation
     *
     * @return array
     */
    protected function translateByRule(array $result, array $payload, string $key, $translation): array
    {
        if (is_callable($translation)) {
            return $this->translateCallable($result, $payload, $key, $translation);
        }
        if (is_array($translation)) {
            return $this->translateValue($result, $payload, $key, $translation);
        }
        if (is_string($translation)) {
            return $this->translateValue($result, $payload, $key, [$translation]);
        }

        return $result;
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param callable $translation
     *
     * @return array
     */
    protected function translateCallable(array $result, array $payload, string $key, callable $translation): array
    {
        $inputValue = $this->arrayManager->getValueByKey($payload, $key);
        $resultValue = $translation($inputValue, $key, $result);
        $this->getProcessLogger()->debug(
            static::OPERATION,
            [
                static::KEY_KEY => $key,
                static::KEY_OPERATION_TYPE => $translation,
                static::KEY_AFFECTED_DATA => $inputValue,
                static::KEY_RESULTED_DATA => $resultValue,
            ]
        );

        return $this->arrayManager->putValue($result, $key, $resultValue);
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param array $translation
     *
     * @return array
     */
    protected function translateValue(array $result, array $payload, string $key, array $translation): array
    {
        $options = isset($translation[static::KEY_OPTIONS]) ? $translation[static::KEY_OPTIONS] : [];
        /** @var \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface $translateFunction */
        $translateFunctionPlugin = $this->translatorFunctionResolver->getTranslatorFunctionPluginByName(reset($translation));

        $inputValue = $this->arrayManager->getValueByKey($result, $key);
        $resultValue = $translateFunctionPlugin->translate($inputValue, $options);
        $this->getProcessLogger()->debug(
            static::OPERATION,
            [
                static::KEY_KEY => $key,
                static::KEY_OPERATION_TYPE => reset($translation),
                static::KEY_AFFECTED_DATA => $inputValue,
                static::KEY_RESULTED_DATA => $resultValue,
            ]
        );

        return $this->arrayManager->putValue($result, $key, $resultValue);
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $translation
     *
     * @return array
     */
    protected function translateNestedKeys(array $result, array $payload, string $key, $translation): array
    {
        $keys = $this->arrayManager->getAllNestedKeys($result, $key);
        foreach ($keys as $key) {
            $result = $this->translateByRuleSet($result, $payload, $key, $translation);
        }

        return $result;
    }
}
