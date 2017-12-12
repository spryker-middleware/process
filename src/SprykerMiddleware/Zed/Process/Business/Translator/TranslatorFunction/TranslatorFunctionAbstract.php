<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

abstract class TranslatorFunctionAbstract implements TranslatorFunctionInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    abstract public function translate($value);

    /**
     * @param array $options
     *
     * @return void
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }
}
