<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
