<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

interface TranslatorFunctionInterface
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function translate($value);
}
