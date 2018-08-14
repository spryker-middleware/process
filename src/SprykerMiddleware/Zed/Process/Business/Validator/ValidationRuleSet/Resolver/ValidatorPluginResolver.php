<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\Resolver;

use SprykerMiddleware\Zed\Process\Business\Exception\MissingValidatorPluginException;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\ValidatorPluginInterface;

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

class ValidatorPluginResolver implements ValidatorPluginResolverInterface
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
     * @param string $validatorPluginName
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MissingValidatorPluginException
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\ValidatorPluginInterface
     */
    public function getValidatorPluginByName(string $validatorPluginName): ValidatorPluginInterface
    {
        foreach ($this->configurationProfilePluginsStack as $profile) {
            foreach ($profile->getValidatorPlugins() as $validatorPlugin) {
                if ($validatorPlugin->getName() === $validatorPluginName) {
                    return $validatorPlugin;
                }
            }
        }

        throw new MissingValidatorPluginException(sprintf(
            'Missing "%s" validator plugin. You need to add your validator plugin to configuration profile',
            $validatorPluginName
        ));
    }
}
