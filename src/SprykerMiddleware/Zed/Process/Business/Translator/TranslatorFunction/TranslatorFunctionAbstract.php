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
     * @return void
     */
    public function setOptions(array $options): void
    {
        $this->checkRequiredOptions($options);
        $this->options = $options;
    }

    /**
     * @param array $options
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MissingRequiredOptionsTranslatorException
     *
     * @return void
     */
    protected function checkRequiredOptions(array $options): void
    {
        foreach ($this->requiredOptions as $requiredOption) {
            if (!in_array($requiredOption, array_keys($options))) {
                throw new MissingRequiredOptionsTranslatorException('Missing required option: ' . $requiredOption);
            }
        }
    }
}
