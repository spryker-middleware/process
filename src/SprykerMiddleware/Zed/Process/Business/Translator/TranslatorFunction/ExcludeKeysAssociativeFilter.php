<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class ExcludeKeysAssociativeFilter extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @var array
     */
    protected $requiredOptions = [
        'excludeKeys',
    ];

    /**
     * @param array $value
     *
     * @return array
     */
    public function translate($value)
    {
        return array_diff_key($value, array_flip($this->options['excludeKeys']));
    }
}
