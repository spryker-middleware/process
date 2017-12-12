<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class DateTimeToString extends TranslatorFunctionAbstract implements TranslatorFunctionInterface
{
    /**
     * @param \DateTime $value
     *
     * @return string
     */
    public function translate($value)
    {
        return $value->format($this->options['format']);
    }
}
