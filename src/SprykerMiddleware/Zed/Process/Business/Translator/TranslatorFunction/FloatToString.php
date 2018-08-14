<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class FloatToString extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @param float $value
     * @param array $payload
     *
     * @return string
     */
    public function translate($value, array $payload): string
    {
        return (string)$value;
    }
}
