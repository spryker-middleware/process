<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class MoneyDecimalToInteger extends AbstractTranslatorFunction
{
    protected const PRICE_PRECISION = 100;

    /**
     * @param float $value
     * @param array $payload
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return int
     */
    public function translate($value, array $payload): int
    {
        if (!is_float($value)) {
            throw new WrongTypeValueTranslatorException(static::class, $this->key, 'float', $value);
        }

        return (int)round($value * static::PRICE_PRECISION);
    }
}
