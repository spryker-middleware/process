<?php

namespace SprykerMiddleware\Zed\Process\Business\Exception;

use Exception;
use Spryker\Shared\Kernel\Exception\Backtrace;

class IteratorNotConfiguredException extends Exception
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
        $message .= 'Iterator for process' . $processName . ' does not configured' . PHP_EOL;
        $message .= 'You can fix this by adding the missing configuration to .' . PHP_EOL;
        $message .= 'Pyz\\Zed\\Process\\ProcessConfig::getProcessIteratorsConfig()' . PHP_EOL . PHP_EOL;
        $message .= new Backtrace();

        return $message;
    }
}
