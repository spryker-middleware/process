<?php

namespace SprykerMiddleware\Zed\Process\Business\Log;

use Spryker\Shared\Log\Config\LoggerConfigInterface;

trait LoggerTrait
{
    /**
     * @return \Psr\Log\LoggerInterface
     */
    protected function getLogger()
    {
        return LoggerFactory::getInstance();
    }

    /**
     * @param \Spryker\Shared\Log\Config\LoggerConfigInterface $loggerConfig
     *
     * @return void
     */
    public static function initLogger(LoggerConfigInterface $loggerConfig)
    {
        LoggerFactory::initLogger($loggerConfig);
    }
}
