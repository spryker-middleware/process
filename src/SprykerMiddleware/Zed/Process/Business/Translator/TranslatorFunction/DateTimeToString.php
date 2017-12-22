<?php

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
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return string
     */
    public function translate($value)
    {
        if (!($value instanceof DateTime)) {
            throw new WrongTypeValueTranslatorException();
        }

        return $value->format($this->options['format']);
    }
}
