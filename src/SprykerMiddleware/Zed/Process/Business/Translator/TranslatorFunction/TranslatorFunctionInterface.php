<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

interface TranslatorFunctionInterface
{
    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return mixed
     */
    public function translate($value, array $payload);

    /**
     * @param array $options
     *
     * @return void
     */
    public function setOptions(array $options): void;

    /**
     * @param string $key
     *
     * @return void
     */
    public function setKey(string $key): void;
}
