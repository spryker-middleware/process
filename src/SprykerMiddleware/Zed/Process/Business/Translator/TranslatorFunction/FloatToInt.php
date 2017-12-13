<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class FloatToInt extends TranslatorFunctionAbstract implements TranslatorFunctionInterface
{
    /**
     * @param float $value
     *
     * @return int
     */
    public function translate($value)
    {
        return (int)$value;
    }
}
