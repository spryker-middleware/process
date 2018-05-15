<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Log;

use Monolog\Handler\HandlerInterface;

interface MiddlewareLogHandlerPluginInterface extends HandlerInterface
{
    /**
     * @param int|string $level
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    public function setLevel($level): HandlerInterface;
}
