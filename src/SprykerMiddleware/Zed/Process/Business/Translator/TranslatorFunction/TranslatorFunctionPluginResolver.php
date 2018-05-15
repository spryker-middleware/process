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
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[]
     */
    protected $configurationProfilePluginsStack;

    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[] $configurationProfilePluginsStack
     */
    public function __construct(array $configurationProfilePluginsStack)
    {
        $this->configurationProfilePluginsStack = $configurationProfilePluginsStack;
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
        foreach ($this->configurationProfilePluginsStack as $profile) {
            foreach ($profile->getTranslatorFunctionPlugins() as $translatorFunctionPlugin) {
                if ($translatorFunctionPlugin->getName() === $translatorFunctionPluginName) {
                    return $translatorFunctionPlugin;
                }
            }
        }

        throw new MissingTranslatorFunctionPluginException(sprintf(
            'Missing "%s" translator function plugin. You need to add your translator function to configuration profile',
            $translatorFunctionPluginName
        ));
    }
}
