<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class MoneyIntegerToDecimal extends TranslatorFunctionAbstract
{
    const PRICE_PRECISION = 100;

    /**
     * @param int $value
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return float
     */
    public function translate($value)
    {
        if (!is_int($value)) {
            throw new WrongTypeValueTranslatorException();
        }

        return (float)bcdiv($value, static::PRICE_PRECISION, 2);
    }
}
