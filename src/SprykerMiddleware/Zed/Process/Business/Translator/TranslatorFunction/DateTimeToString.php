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
    /**
     * @var array
     */
    protected $requiredOptions = [
        'format',
    ];

    /**
     * @param \DateTime $value
     * @param array $payload
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return string
     */
    public function translate($value, array $payload)
    {
        if (!($value instanceof DateTime)) {
            throw new WrongTypeValueTranslatorException(static::class, $this->key, '\DateTime', $value);
        }

        return $value->format($this->options['format']);
    }
}
