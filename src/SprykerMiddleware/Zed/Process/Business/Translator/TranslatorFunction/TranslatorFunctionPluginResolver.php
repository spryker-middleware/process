<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\MissingTranslatorFunctionPluginException;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\TranslatorFunctionPluginInterface;

class TranslatorFunctionPluginResolver implements TranslatorFunctionPluginResolverInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\TranslatorFunctionPluginInterface[]
     */
    protected $translatorFunctionPlugins;

    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[] $configurationProfilePluginsStack
     */
    public function __construct(array $configurationProfilePluginsStack)
    {
        $this->translatorFunctionPlugins = $this->generateTranslatorFunctionPluginList($configurationProfilePluginsStack);
    }

    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[] $configurationProfilePluginsStack
     *
     * @return array
     */
    protected function generateTranslatorFunctionPluginList(array $configurationProfilePluginsStack): array
    {
        $translatorFunctionPluginList = [];

        foreach ($configurationProfilePluginsStack as $profile) {
            foreach ($profile->getTranslatorFunctionPlugins() as $translatorFunctionPlugin) {
                $translatorFunctionPluginList[$translatorFunctionPlugin->getName()] = $translatorFunctionPlugin;
            }
        }

        return $translatorFunctionPluginList;
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
        if ($this->issetTranslationFunctionPlugin($translatorFunctionPluginName)) {
            return $this->getTranslationFunctionPlugin($translatorFunctionPluginName);
        }

        throw new MissingTranslatorFunctionPluginException(sprintf(
            'Missing "%s" translator function plugin. You need to add your translator function to configuration profile',
            $translatorFunctionPluginName
        ));
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    protected function issetTranslationFunctionPlugin(string $name): bool
    {
        return isset($this->translatorFunctionPlugins[$name]);
    }

    /**
     * @param string $name
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\TranslatorFunctionPluginInterface
     */
    protected function getTranslationFunctionPlugin(string $name): TranslatorFunctionPluginInterface
    {
        return $this->translatorFunctionPlugins[$name];
    }
}
