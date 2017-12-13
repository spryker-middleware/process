<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class Enum extends TranslatorFunctionAbstract implements TranslatorFunctionInterface
{
    /**
     * @var array
     */
    protected $requiredOptions = [
        'map',
    ];

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function translate($value)
    {
        if (is_array($this->options['map']) && isset($this->options['map'][$value])) {
            return $this->options['map'][$value];
        }
    }
}
