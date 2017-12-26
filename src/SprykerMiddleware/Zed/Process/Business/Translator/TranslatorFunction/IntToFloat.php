<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class IntToFloat extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @param int $value
     *
     * @return float
     */
    public function translate($value)
    {
        return (float)$value;
    }
}
