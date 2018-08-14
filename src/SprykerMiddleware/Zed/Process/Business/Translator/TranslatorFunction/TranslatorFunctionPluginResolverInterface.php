<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\TranslatorFunctionPluginInterface;

interface TranslatorFunctionPluginResolverInterface
{
    /**
     * @param string $translatorFunctionPluginName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\TranslatorFunctionPluginInterface
     */
    public function getTranslatorFunctionPluginByName(string $translatorFunctionPluginName): TranslatorFunctionPluginInterface;
}
