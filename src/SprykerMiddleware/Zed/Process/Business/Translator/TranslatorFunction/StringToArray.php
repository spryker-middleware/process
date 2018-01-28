<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class StringToArray extends AbstractTranslatorFunction
{
    const OPTION_DELIMITER = 'delimiter';

    /**
     * @var array
     */
    protected $requiredOptions = [
        self::OPTION_DELIMITER,
    ];

    /**
     * @param string $value
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return array
     */
    public function translate($value)
    {
        if (!is_string($value)) {
            throw new WrongTypeValueTranslatorException();
        }

        return explode($this->options[self::OPTION_DELIMITER], $value);
    }
}
