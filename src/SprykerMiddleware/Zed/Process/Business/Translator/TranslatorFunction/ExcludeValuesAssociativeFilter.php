<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class ExcludeValuesAssociativeFilter extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @var array
     */
    protected $requiredOptions = [
        'excludeValues',
    ];

    /**
     * @param array $value
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return array
     */
    public function translate($value)
    {
        if (!is_array($value)) {
            throw new WrongTypeValueTranslatorException();
        }

        return array_diff($value, $this->options['excludeValues']);
    }
}
