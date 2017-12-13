<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class StringToBool extends TranslatorFunctionAbstract implements TranslatorFunctionInterface
{
    /**
     * @param string $value
     *
     * @return bool
     */
    public function translate($value)
    {
        return strtolower($value) === 'true';
    }
}
