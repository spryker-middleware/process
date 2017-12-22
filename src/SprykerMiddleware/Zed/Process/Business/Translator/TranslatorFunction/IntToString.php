<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class IntToString extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @param int $value
     *
     * @return string
     */
    public function translate($value)
    {
        return (string)$value;
    }
}
