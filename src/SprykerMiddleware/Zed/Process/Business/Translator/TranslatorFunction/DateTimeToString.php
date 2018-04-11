<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use DateTime;
use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class DateTimeToString extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    public const FORMAT = 'format';
    /**
     * @var array
     */
    protected $requiredOptions = [
        self::FORMAT,
    ];

    /**
     * @param \DateTime $value
     * @param array $payload
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return string
     */
    public function translate($value, array $payload): string
    {
        if (!($value instanceof DateTime)) {
            throw new WrongTypeValueTranslatorException(static::class, $this->key, '\DateTime', $value);
        }

        return $value->format($this->options[static::FORMAT]);
    }
}
