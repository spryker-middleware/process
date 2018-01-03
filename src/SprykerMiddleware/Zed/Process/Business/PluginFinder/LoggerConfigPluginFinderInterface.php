<?php

namespace SprykerMiddleware\Zed\Process\Business\PluginFinder;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface;

interface LoggerConfigPluginFinderInterface
{
    /**
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    public function getLoggerConfigPluginByProcessName(string $processName): MiddlewareLoggerConfigPluginInterface;
}
