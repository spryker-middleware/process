<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class Enum extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    const OPTION_MAP = 'map';
    /**
     * @var array
     */
    protected $requiredOptions = [
        self::OPTION_MAP,
    ];

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function translate($value)
    {
        if (is_array($this->options[self::OPTION_MAP]) && isset($this->options[self::OPTION_MAP][$value])) {
            return $this->options[self::OPTION_MAP][$value];
        }
    }
}
