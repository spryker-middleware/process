<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class BoolToString extends TranslatorFunctionAbstract implements TranslatorFunctionInterface
{
    /**
     * @param bool $value
     *
     * @return string
     */
    public function translate($value)
    {
        return $value ? 'true' : 'false';
    }
}
