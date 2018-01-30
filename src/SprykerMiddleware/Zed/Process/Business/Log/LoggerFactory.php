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
     * @param \Spryker\Shared\Log\Config\LoggerConfigInterface|null $loggerConfig
     *
     * @return \Psr\Log\LoggerInterface
     */
    public static function getInstance(LoggerConfigInterface $loggerConfig = null)
    {
        if ($loggerConfig !== null) {
            static::$loggerConfig = $loggerConfig;
        }

        return SprykerLoggerFactory::getInstance(static::$loggerConfig);
    }
}
