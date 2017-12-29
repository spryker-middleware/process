<?php

namespace SprykerMiddleware\Zed\Process\Business\Log\Config;

use Generated\Shared\Transfer\LoggerSettingsTransfer;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
use Spryker\Shared\Log\Config\LoggerConfigInterface;

class MiddlewareLoggerConfig implements LoggerConfigInterface
{
    const CHANNEL_NAME = 'SprykerMiddleware';

    /**
     * @var \Generated\Shared\Transfer\LoggerSettingsTransfer
     */
    protected $loggerSettings;

    /**
     * @param \Generated\Shared\Transfer\LoggerSettingsTransfer $loggerSettings
     */
    public function __construct(LoggerSettingsTransfer $loggerSettings)
    {
        $this->loggerSettings = $loggerSettings;
    }

    /**
     * @return string
     */
    public function getChannelName(): string
    {
        return static::CHANNEL_NAME;
    }

    /**
     * @return \Monolog\Handler\HandlerInterface[]
     */
    public function getHandlers(): array
    {
        $handlers = [];
        if (!$this->loggerSettings->getIsQuiet()) {
            $handlers[] = $this->createStdErrStreamHandler();
        }

        return $handlers;
    }

    /**
     * @return callable[]
     */
    public function getProcessors(): array
    {
        return [
            new PsrLogMessageProcessor(),
            new IntrospectionProcessor(),
        ];
    }

    /**
     * @return \Monolog\Handler\StreamHandler
     */
    protected function createStdErrStreamHandler(): StreamHandler
    {
        $streamHandler = new StreamHandler(
            'php://stderr',
            $this->loggerSettings->getVerboseLevel()
        );
        $formatter = new LogstashFormatter(static::CHANNEL_NAME);
        $streamHandler->setFormatter($formatter);

        return $streamHandler;
    }
}
