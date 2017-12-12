<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\MissingRequiredOptionsTranslatorException;

abstract class TranslatorFunctionAbstract implements TranslatorFunctionInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $requiredOptions = [];

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    abstract public function translate($value);

    /**
     * @param array $options
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MissingRequiredOptionsTranslatorException
     *
     * @return void
     */
    public function setOptions(array $options): void
    {
        if (!$this->checkRequiredOptions($options)) {
            throw new MissingRequiredOptionsTranslatorException();
        }
        
        $this->options = $options;
    }

    /**
     * @param array $options
     *
     * @return bool
     */
    protected function checkRequiredOptions(array $options): bool
    {
        foreach ($this->requiredOptions as $requiredOption) {
            if (!in_array($requiredOption, array_keys($options))) {
                return false;
            }
        }

        return true;
    }
}
