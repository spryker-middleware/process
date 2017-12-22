<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use DateTime;

class StringToDateTime extends AbstractTranslatorFunction implements TranslatorFunctionInterface
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
