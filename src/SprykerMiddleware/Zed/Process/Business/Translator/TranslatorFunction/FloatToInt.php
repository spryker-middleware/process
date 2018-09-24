<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class FloatToInt extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @param float $value
     * @param array $payload
     *
     * @return int
     */
    public function translate($value, array $payload): int
    {
        return (int)$value;
    }
}
