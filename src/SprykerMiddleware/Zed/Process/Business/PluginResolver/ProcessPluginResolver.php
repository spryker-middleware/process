<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\PluginResolver;

use SprykerMiddleware\Zed\Process\Business\Exception\ProcessConfigurationNotFoundException;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;

class ProcessPluginResolver implements ProcessPluginResolverInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[]
     */
    protected $configurationProfilePluginsStack;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    protected $processPluginsStack;

    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[] $configurationProfilePluginsStack
     */
    public function __construct(array $configurationProfilePluginsStack)
    {
        $this->configurationProfilePluginsStack = $configurationProfilePluginsStack;
        foreach ($this->configurationProfilePluginsStack as $profile) {
            foreach ($profile->getProcessConfigurationPlugins() as $process) {
                $this->processPluginsStack[$processConfig->getProcessName()] = $process;
            }
        }
    }

    /**
     * @param string $processName
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\ProcessConfigurationNotFoundException
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface
     */
    public function getProcessConfigurationPluginByProcessName(string $processName): ProcessConfigurationPluginInterface
    {
        if (isset($this->processPluginsStack[$processName])) {
            return $this->processPluginsStack[$processName];
        }

        throw new ProcessConfigurationNotFoundException();
    }
}
