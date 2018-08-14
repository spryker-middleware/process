<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Exception;

use Exception;

class MissingValidatorRequiredOptionsException extends Exception
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
        $message = sprintf('Required option "%s" to validate key "%s" is not specified.', $requiredOption, $key);
        $message .= sprintf("\nValidator: %s\n", $className);
        $message .= sprintf("Specified options: [%s]", implode(', ', array_keys($options)));

        return $message;
    }
}
