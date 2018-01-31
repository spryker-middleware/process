<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class MoneyIntegerToDecimal extends AbstractTranslatorFunction
{
    const PRICE_PRECISION = 100;

    /**
     * @param int $value
     * @param array $payload
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return float
     */
    public function translate($value, array $payload)
    {
        if (!is_int($value)) {
            throw new WrongTypeValueTranslatorException(static::class, $this->key, 'int', $value);
        }

        return (float)bcdiv($value, static::PRICE_PRECISION, 2);
    }
}
