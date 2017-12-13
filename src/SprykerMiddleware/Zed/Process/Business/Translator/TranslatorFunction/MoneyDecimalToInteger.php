<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class MoneyDecimalToInteger extends TranslatorFunctionAbstract
{
    const PRICE_PRECISION = 100;

    /**
     * @param float $value
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return int
     */
    public function translate($value)
    {
        if (!is_float($value)) {
            throw new WrongTypeValueTranslatorException();
        }

        return (int)round($value * static::PRICE_PRECISION);
    }
}
