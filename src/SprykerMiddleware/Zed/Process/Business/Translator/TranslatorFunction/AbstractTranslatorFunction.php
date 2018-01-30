<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\MissingRequiredOptionsTranslatorException;

abstract class AbstractTranslatorFunction implements TranslatorFunctionInterface
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
     *
     * @return mixed
     */
    abstract public function translate($value);

    /**
     * @param array $options
     *
     * @return void
     */
    public function setOptions(array $options): void
    {
        $this->checkRequiredOptions($options);
        $this->options = $options;
    }

    /**
     * @param string $key
     *
     * @return void
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @param array $options
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MissingRequiredOptionsTranslatorException
     *
     * @return void
     */
    protected function checkRequiredOptions(array $options): void
    {
        foreach ($this->requiredOptions as $requiredOption) {
            if (!in_array($requiredOption, array_keys($options))) {
                throw new MissingRequiredOptionsTranslatorException(static::class, $this->key, $options, $requiredOption);
            }
        }
    }
}
