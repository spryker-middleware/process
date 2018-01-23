<?php

namespace SprykerMiddleware\Zed\Process\Business\Exception;

use Exception;

class MissingRequiredOptionsTranslatorException extends Exception
{
    /**
     * @param string $className
     * @param string $key
     * @param array $options
     * @param string $requiredOption
     */
    public function __construct(string $className, string $key, array $options, string $requiredOption)
    {
        parent::__construct($this->buildMessage($className, $key, $options, $requiredOption));
    }

    /**
     * @param string $className
     * @param string $key
     * @param array $options
     * @param string $requiredOption
     *
     * @return string
     */
    protected function buildMessage(string $className, string $key, array $options, string $requiredOption): string
    {
        $message = sprintf('Required option "%s" to translate key "%s" is not specified.', $requiredOption, $key);
        $message .= sprintf("\nTranslation function: %s\n", $className);
        $message .= sprintf("Specified options: [%s]", implode(', ', array_keys($options)));

        return $message;
    }
}
