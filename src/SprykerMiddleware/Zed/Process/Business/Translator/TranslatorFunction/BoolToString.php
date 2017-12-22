<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class BoolToString extends AbstractTranslatorFunction implements TranslatorFunctionInterface
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
