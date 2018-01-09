<?php

namespace SprykerMiddleware\Zed\Process\Business\PluginResolver;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;

interface ProcessPluginResolverInterface
{
    /**
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface
     */
    public function getProcessConfigurationPluginByProcessName(string $processName): ProcessConfigurationPluginInterface;
}
