<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use DateTime;

class StringToDateTime extends TranslatorFunctionAbstract implements TranslatorFunctionInterface
{
    /**
     * @param string $value
     *
     * @return \DateTime
     */
    public function translate($value)
    {
        return new DateTime($value);
    }
}
