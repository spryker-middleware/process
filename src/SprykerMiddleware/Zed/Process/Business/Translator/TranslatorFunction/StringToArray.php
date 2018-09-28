<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class StringToArray extends AbstractTranslatorFunction
{
    public const OPTION_DELIMITER = 'delimiter';

    /**
     * @var array
     */
    protected $requiredOptions = [
        self::OPTION_DELIMITER,
    ];

    /**
     * @param string $value
     * @param array $payload
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return array
     */
    public function translate($value, array $payload): array
    {
        if (!is_string($value)) {
            throw new WrongTypeValueTranslatorException(static::class, $this->key, 'string', $value);
        }

        return explode($this->options[self::OPTION_DELIMITER], $value);
    }
}
