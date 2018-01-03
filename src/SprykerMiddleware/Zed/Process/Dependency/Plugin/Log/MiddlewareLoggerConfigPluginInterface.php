<?php

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Log;

use Spryker\Shared\Log\Config\LoggerConfigInterface;

interface MiddlewareLoggerConfigPluginInterface extends LoggerConfigInterface
{
    /**
     * Sets minimum logging level at which all handlers will be triggered.
     *
     * @param int|string $level Level or level name
     *
     * @return void
     */
    public function changeLogLevel($level);
}
