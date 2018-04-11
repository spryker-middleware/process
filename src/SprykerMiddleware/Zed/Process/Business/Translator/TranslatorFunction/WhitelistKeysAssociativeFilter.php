<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class WhitelistKeysAssociativeFilter extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    public const OPTION_WHITELIST_KEYS = 'whitelistKeys';

    /**
     * @var array
     */
    protected $requiredOptions = [
        self::OPTION_WHITELIST_KEYS,
    ];

    /**
     * @param array $value
     * @param array $payload
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return array
     */
    public function translate($value, array $payload): array
    {
        if (!is_array($value)) {
            throw new WrongTypeValueTranslatorException(static::class, $this->key, 'array', $value);
        }

        return array_intersect_key($value, array_flip($this->options[self::OPTION_WHITELIST_KEYS]));
    }
}
