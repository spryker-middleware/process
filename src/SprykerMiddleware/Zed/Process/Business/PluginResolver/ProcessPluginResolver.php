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
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    protected $processesPluginsStack;

    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[] $processesPluginsStack
     */
    public function __construct(array $processesPluginsStack)
    {
        $this->processesPluginsStack = $processesPluginsStack;
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
        foreach ($this->processesPluginsStack as $processConfigurationPlugin) {
            if ($processConfigurationPlugin->getProcessName() === $processName) {
                return $processConfigurationPlugin;
            }
        }

        throw new ProcessConfigurationNotFoundException();
    }
}
