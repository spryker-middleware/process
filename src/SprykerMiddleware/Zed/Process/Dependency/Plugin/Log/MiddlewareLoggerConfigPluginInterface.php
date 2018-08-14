<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Log;

use Spryker\Shared\Log\Config\LoggerConfigInterface;

interface MiddlewareLoggerConfigPluginInterface extends LoggerConfigInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * Sets minimum logging level at which all handlers will be triggered.
     *
     * @param int|string $level Level or level name
     *
     * @return void
     */
    public function changeLogLevel($level): void;
}
