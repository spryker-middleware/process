<?php

namespace SprykerMiddleware\Zed\Process\Business\Log\Config;

use Generated\Shared\Transfer\LoggerSettingsTransfer;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Shared\Log\LogConstants;

class MiddlewareLoggerConfig implements LoggerConfigInterface
{
    const NAME = 'SprykerMiddleware';

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
        return static::NAME;
    }

    /**
     * @return \Monolog\Handler\HandlerInterface[]
     */
    public function getHandlers(): array
    {
        $handlers = [
            $this->createStreamHandler(),
        ];
        if (!$this->loggerSettings->getIsQuiet()) {
            $handlers[] = $this->createConsoleStreamHandler();
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
        ];
    }

    /**
     * @return \Monolog\Handler\StreamHandler
     */
    protected function createStreamHandler(): StreamHandler
    {
        $streamHandler = new StreamHandler(
            $this->getLogFilePath(),
            $this->loggerSettings->getVerboseLevel()
        );
        $formatter = new LogstashFormatter(static::NAME);
        $streamHandler->setFormatter($formatter);

        return $streamHandler;
    }

    /**
     * @return \Monolog\Handler\StreamHandler
     */
    protected function createConsoleStreamHandler(): StreamHandler
    {
        $streamHandler = new StreamHandler(
            'php://stdout',
            $this->loggerSettings->getVerboseLevel()
        );
        $formatter = new LogstashFormatter(static::NAME);
        $streamHandler->setFormatter($formatter);

        return $streamHandler;
    }

    /**
     * @return string
     */
    protected function getLogFilePath(): string
    {
        return Config::get(LogConstants::LOG_FILE_PATH_ZED);
    }
}
