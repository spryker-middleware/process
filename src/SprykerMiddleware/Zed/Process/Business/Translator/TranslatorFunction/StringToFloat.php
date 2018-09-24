<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class StringToFloat extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @param string $value
     * @param array $payload
     *
     * @return float
     */
    public function translate($value, array $payload): float
    {
        return (float)$value;
    }
}
