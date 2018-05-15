<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

use SprykerMiddleware\Zed\Process\Business\Exception\MissingValidatorRequiredOptionsException;

abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $requiredOptions = [];

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return bool
     */
    abstract public function validate($value, array $payload): bool;

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->checkRequiredOptions($options);
        $this->options = $options;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @param array $options
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MissingValidatorRequiredOptionsException
     *
     * @return void
     */
    protected function checkRequiredOptions(array $options): void
    {
        foreach ($this->requiredOptions as $requiredOption) {
            if (!in_array($requiredOption, array_keys($options))) {
                throw new MissingValidatorRequiredOptionsException(static::class, $this->key, $options, $requiredOption);
            }
        }
    }
}
