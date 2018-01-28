<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Shared\Process\Log;

use Exception;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Shared\Log\LoggerTrait;

trait MiddlewareLoggerTrait
{
    use LoggerTrait;

    /**
     * @throws \Exception
     *
     * @return \Psr\Log\LoggerInterface
     */
    protected function getProcessLogger()
    {
        if (MiddlewareLoggerContainer::getLogger()) {
            return MiddlewareLoggerContainer::getLogger();
        }

        throw new Exception();
    }

    /**
     * @param \Spryker\Shared\Log\Config\LoggerConfigInterface $loggerConfig
     *
     * @return void
     */
    public function initLogger(LoggerConfigInterface $loggerConfig)
    {
        if (!MiddlewareLoggerContainer::getLogger()) {
            MiddlewareLoggerContainer::setLogger($this->getLogger($loggerConfig));
        }
    }
}
