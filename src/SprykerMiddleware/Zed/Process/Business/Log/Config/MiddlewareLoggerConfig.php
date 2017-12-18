<?php

namespace SprykerMiddleware\Zed\Process\Business\Log\Config;

use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Shared\Log\LogConstants;

class MiddlewareLoggerConfig implements LoggerConfigInterface
{
    /**
     * @return string
     */
    public function getChannelName()
    {
        return 'SprykerMiddleware';
    }

    /**
     * @return \Monolog\Handler\HandlerInterface[]
     */
    public function getHandlers()
    {
        $handler = [
            $this->createStreamHandler(),
            $this->createConsoleStreamHandler(),
        ];

        return $handler;
    }

    /**
     * @return callable[]
     */
    public function getProcessors()
    {
        return [
            new PsrLogMessageProcessor(),
        ];
    }

    /**
     * @return \Monolog\Handler\StreamHandler
     */
    protected function createStreamHandler()
    {
        $streamHandler = new StreamHandler(
            Config::get(LogConstants::LOG_FILE_PATH_ZED),
            Config::get(LogConstants::LOG_LEVEL, Logger::INFO)
        );
        $formatter = new LogstashFormatter('SprykerMiddleware');
        $streamHandler->setFormatter($formatter);

        return $streamHandler;
    }

    /**
     * @return \Monolog\Handler\StreamHandler
     */
    protected function createConsoleStreamHandler()
    {
        $streamHandler = new StreamHandler(
            'php://stdout',
            Config::get(LogConstants::LOG_LEVEL, Logger::INFO)
        );
        $formatter = new LogstashFormatter('SprykerMiddleware');
        $streamHandler->setFormatter($formatter);

        return $streamHandler;
    }
}
