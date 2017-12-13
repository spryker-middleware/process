<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class StringToArray extends TranslatorFunctionAbstract
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
