<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Exception;

class WrongTypeValueTranslatorException extends TolerableProcessException
{
    /**
     * @param string $className
     * @param string $key
     * @param string $expectedType
     * @param mixed $value
     */
    public function __construct(string $className, string $key, string $expectedType, $value)
    {
        parent::__construct($this->buildMessage($className, $key, $expectedType, $value));
    }

    /**
     * @param string $className
     * @param string $key
     * @param string $expectedType
     * @param mixed $value
     *
     * @return string
     */
    protected function buildMessage(string $className, string $key, string $expectedType, $value): string
    {
        $actualType = is_object($value) ? get_class($value) : gettype($value);
        $message = sprintf('Expected argument of type "%s", "%s" given.', $expectedType, $actualType);
        $message .= sprintf("\nTranslation function: %s\n", $className);
        $message .= sprintf("Key to translate: %s", $key);
        return $message;
    }
}
