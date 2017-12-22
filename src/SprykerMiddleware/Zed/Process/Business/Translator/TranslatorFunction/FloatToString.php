<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class FloatToString extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @param float $value
     *
     * @return string
     */
    public function translate($value)
    {
        return (string)$value;
    }
}
