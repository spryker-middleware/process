<?php

namespace SprykerMiddleware\Zed\Process\Business\PluginFinder;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface;
use SprykerMiddleware\Zed\Process\ProcessConfig;

class LoggerConfigPluginFinder implements LoggerConfigPluginFinderInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\ProcessConfig
     */
    protected $config;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface[]
     */
    protected $loggerConfigPluginsStack;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    protected $defaultLoggerConfigPlugin;

    /**
     * @param \SprykerMiddleware\Zed\Process\ProcessConfig $config
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface[] $loggerConfigPluginsStack
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface $defaultLoggerConfigPlugin
     */
    public function __construct(
        ProcessConfig $config,
        array $loggerConfigPluginsStack,
        MiddlewareLoggerConfigPluginInterface $defaultLoggerConfigPlugin
    ) {
        $this->config = $config;
        $this->loggerConfigPluginsStack = $loggerConfigPluginsStack;
        $this->defaultLoggerConfigPlugin = $defaultLoggerConfigPlugin;
        $this->init();
    }

    /**
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    public function getLoggerConfigPluginByProcessName(string $processName): MiddlewareLoggerConfigPluginInterface
    {
        $channelName = $this->getLoggerConfigPluginChannelName($processName);
        if ($channelName) {
            return $this->loggerConfigPluginsStack[$channelName];
        }

        return $this->defaultLoggerConfigPlugin;
    }

    /**
     * @return void
     */
    protected function init()
    {
        $loggerConfigPluginsStack = [];
        foreach ($this->loggerConfigPluginsStack as $loggerConfigPlugin) {
            $loggerConfigPluginsStack[$loggerConfigPlugin->getChannelName()] = $loggerConfigPlugin;
        }
        $this->loggerConfigPluginsStack = $loggerConfigPluginsStack;
    }

    /**
     * @param string $processName
     *
     * @return string|null
     */
    protected function getLoggerConfigPluginChannelName(string $processName)
    {
        $processLoggersConfig = $this->config->getProcessLoggersConfig();
        if (isset($processLoggersConfig[$processName])) {
            return $processLoggersConfig[$processName];
        }

        return null;
    }
}
