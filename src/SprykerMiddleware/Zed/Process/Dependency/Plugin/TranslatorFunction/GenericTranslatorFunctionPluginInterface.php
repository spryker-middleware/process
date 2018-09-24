<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction;

interface GenericTranslatorFunctionPluginInterface extends TranslatorFunctionPluginInterface
{
    /**
     * @api
     *
     * @return string
     */
    public function getTranslatorFunctionClassName(): string;
}
