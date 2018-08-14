<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\ExcludeKeysAssociativeFilter;

class ExcludeKeysAssociativeFilterTranslatorFunctionPlugin extends AbstractGenericTranslatorFunctionPlugin
{
    public const NAME = 'ExcludeKeysAssociativeFilter';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public function getTranslatorFunctionClassName(): string
    {
        return ExcludeKeysAssociativeFilter::class;
    }
}
