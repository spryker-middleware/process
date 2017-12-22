<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class StringToFloat extends AbstractTranslatorFunction implements TranslatorFunctionInterface
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
