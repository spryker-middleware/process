<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
