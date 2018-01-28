<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class MoneyDecimalToInteger extends AbstractTranslatorFunction
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
