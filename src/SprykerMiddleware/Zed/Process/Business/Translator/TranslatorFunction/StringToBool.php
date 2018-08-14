<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class StringToBool extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    public const VALUE_TRUE = 'true';

    /**
     * @param string $value
     * @param array $payload
     *
     * @return bool
     */
    public function translate($value, array $payload): bool
    {
        return strtolower($value) === static::VALUE_TRUE;
    }
}
