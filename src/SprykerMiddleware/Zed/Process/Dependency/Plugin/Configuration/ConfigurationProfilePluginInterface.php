<?php

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration;

interface ConfigurationProfilePluginInterface
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    public function getProcessConfigurationPlugins(): array;
}
