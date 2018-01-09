<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class ExcludeValuesSequentalFilter extends ExcludeValuesAssociativeFilter
{
    /**
     * @param array $value
     *
     * @return array
     */
    public function translate($value)
    {
        return array_values(parent::translate($value));
    }
}
