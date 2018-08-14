<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class MoneyIntegerToDecimal extends AbstractTranslatorFunction
{
    protected const PRICE_PRECISION = 100;

    /**
     * @param int $value
     * @param array $payload
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return float
     */
    public function translate($value, array $payload): float
    {
        if (!is_int($value)) {
            throw new WrongTypeValueTranslatorException(static::class, $this->key, 'int', $value);
        }

        return (float)bcdiv($value, static::PRICE_PRECISION, 2);
    }
}
