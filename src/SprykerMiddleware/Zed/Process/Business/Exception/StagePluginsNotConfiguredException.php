<?php

namespace SprykerMiddleware\Zed\Process\Business\Exception;

use Exception;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\Exception\Backtrace;
use Spryker\Shared\Kernel\KernelConstants;

class StagePluginsNotConfiguredException extends Exception
{
    /**
     * @param string $processName
     */
    public function __construct(string $processName)
    {
        parent::__construct($this->buildMessage($processName));
    }

    /**
     * @param string $processName
     *
     * @return string
     */
    protected function buildMessage(string $processName)
    {
        $message = 'Spryker Middleware Exception' . PHP_EOL;
        $message .= 'List of stage plugins for process ' . $processName . ' is not configured' . PHP_EOL;
        $message .= 'You can fix this by adding the missing configuration to' . PHP_EOL;
        $message .= sprintf(
            '%s\\Zed\\Process\\ProcessConfig::getProcessIteratorsConfig()' . PHP_EOL . PHP_EOL,
            Config::getInstance()->get(KernelConstants::PROJECT_NAMESPACE)
        );
        $message .= new Backtrace();

        return $message;
    }
}
