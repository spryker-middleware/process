<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

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
     * @return array
     */
    public function translate($value)
    {
        return array_diff($value, $this->options['excludeValues']);
    }
}
