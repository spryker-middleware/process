<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class ExcludeValuesSequentalFilter extends ExcludeValuesAssociativeFilter
{
    /**
     * @param array $value
     * @param array $payload
     *
     * @return array
     */
    public function translate($value, array $payload): array
    {
        return array_values(parent::translate($value, $payload));
    }
}
