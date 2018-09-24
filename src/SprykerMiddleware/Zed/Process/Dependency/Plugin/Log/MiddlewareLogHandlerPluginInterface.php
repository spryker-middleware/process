<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Log;

use Monolog\Handler\HandlerInterface;

interface MiddlewareLogHandlerPluginInterface extends HandlerInterface
{
    /**
     * @api
     *
     * @param int|string $level
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    public function setLevel($level): HandlerInterface;
}
