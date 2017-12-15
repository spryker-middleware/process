<?php

namespace SprykerMiddleware\Zed\Process\Business\Exception;

use Exception;
use Spryker\Shared\Kernel\Exception\Backtrace;

class WriterNotFoundException extends Exception
{
    /**
     * @param string $className
     */
    public function __construct(string $className)
    {
        parent::__construct($this->buildMessage($className));
    }

    /**
     * @param string $className
     *
     * @return string
     */
    protected function buildMessage(string $className)
    {
        $message = 'Spryker Middleware Exception' . PHP_EOL;
        $message .= sprintf(
            'Can not resolve %1$s writer',
            $className
        ) . PHP_EOL;

        $message .= 'You can fix this by adding the missing writer class to your module.' . PHP_EOL;

        $message .= sprintf(
            'E.g. Pyz\\Zed\\Process\\Business\\Writer\\%1$s' . PHP_EOL . PHP_EOL,
            $className
        );

        $message .= new Backtrace();

        return $message;
    }
}
