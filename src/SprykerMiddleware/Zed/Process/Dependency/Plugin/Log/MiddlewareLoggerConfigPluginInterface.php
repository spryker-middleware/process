<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
