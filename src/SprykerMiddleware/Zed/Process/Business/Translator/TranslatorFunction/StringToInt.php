<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class StringToInt extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @param string $value
     *
     * @return int
     */
    public function translate($value)
    {
        return (int)$value;
    }
}
