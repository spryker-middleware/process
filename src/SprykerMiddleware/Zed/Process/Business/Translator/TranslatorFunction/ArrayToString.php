<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class ArrayToString extends AbstractTranslatorFunction
{
    const OPTION_GLUE = 'glue';

    /**
     * @var array
     */
    protected $requiredOptions = [
        self::OPTION_GLUE,
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
        if (!is_array($value)) {
            throw new WrongTypeValueTranslatorException();
        }

        return implode($this->options[self::OPTION_GLUE], $value);
    }
}
