<?php

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Log;

use Monolog\Handler\HandlerInterface;

interface MiddlewareLogHandlerPluginInterface extends HandlerInterface
{
    /**
     * @param int|string $level
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    public function setLevel($level);
}
