<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\ExcludeValuesSequentalFilter;

class ExcludeValuesSequentalFilterTranslatorFunctionPlugin extends AbstractGenericTranslatorFunctionPlugin
{
    public const NAME = 'ExcludeValuesSequentalFilter';

    /**
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getTranslatorFunctionClassName(): string
    {
        return ExcludeValuesSequentalFilter::class;
    }
}
