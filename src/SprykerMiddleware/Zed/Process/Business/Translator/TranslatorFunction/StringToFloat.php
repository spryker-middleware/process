<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class StringToFloat extends TranslatorFunctionAbstract implements TranslatorFunctionInterface
{
    /**
     * @param string $value
     *
     * @return float
     */
    public function translate($value)
    {
        return (float)$value;
    }
}
