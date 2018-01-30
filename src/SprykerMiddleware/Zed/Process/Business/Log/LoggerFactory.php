<?php

namespace SprykerMiddleware\Zed\Process\Business\Log;

use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Shared\Log\LoggerFactory as SprykerLoggerFactory;

class LoggerFactory
{
    /**
     * @var \Spryker\Shared\Log\Config\LoggerConfigInterface
     */
    public static $loggerConfig;

    /**
     * @param \Spryker\Shared\Log\Config\LoggerConfigInterface $loggerConfig
     *
     * @return void
     */
    public static function initLogger(LoggerConfigInterface $loggerConfig)
    {
        static::$loggerConfig = $loggerConfig;
    }

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public static function getInstance()
    {
        return SprykerLoggerFactory::getInstance(static::$loggerConfig);
    }
}
