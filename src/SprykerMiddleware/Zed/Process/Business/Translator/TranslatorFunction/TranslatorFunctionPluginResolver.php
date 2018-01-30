<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\MissingTranslatorFunctionPluginException;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\TranslatorFunctionPluginInterface;

class TranslatorFunctionPluginResolver implements TranslatorFunctionPluginResolverInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\TranslatorFunctionPluginInterface[]
     */
    protected $translatorFunctionPluginStack;

    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\TranslatorFunctionPluginInterface[] $translatorFunctionPluginStack
     */
    public function __construct(array $translatorFunctionPluginStack)
    {
        foreach ($translatorFunctionPluginStack as $translatorFunctionPlugin) {
            $this->translatorFunctionPluginStack[$translatorFunctionPlugin->getName()] = $translatorFunctionPlugin;
        }
    }

    /**
     * @param string $translatorFunctionPluginName
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MissingTranslatorFunctionPluginException
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\TranslatorFunctionPluginInterface
     */
    public function getTranslatorFunctionPluginByName(string $translatorFunctionPluginName): TranslatorFunctionPluginInterface
    {
        if (!isset($this->translatorFunctionPluginStack[$translatorFunctionPluginName])) {
            throw new MissingTranslatorFunctionPluginException(sprintf(
                'Missing "%s" translatro function plugin. You need to register the plugin in ProcessDependencyProvider.',
                $translatorFunctionPluginName
            ));
        }
        return $this->translatorFunctionPluginStack[$translatorFunctionPluginName];
    }
}
