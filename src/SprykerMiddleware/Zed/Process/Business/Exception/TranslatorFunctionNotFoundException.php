<?php


namespace SprykerMiddleware\Zed\Process\Business\Exception;

use Exception;
use Spryker\Shared\Kernel\Exception\Backtrace;

class TranslatorFunctionNotFoundException extends Exception
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
            'Can not resolve %1$s translation function',
            $className
        ) . PHP_EOL;

        $message .= 'You can fix this by adding the missing translationFunction to your bundle.' . PHP_EOL;

        $message .= sprintf(
            'E.g. Pyz\\Zed\\Process\\Business\\Translator\\TranslatorFunction\\%1$s' . PHP_EOL . PHP_EOL,
            $className
        );

        $message .= new Backtrace();

        return $message;
    }
}
