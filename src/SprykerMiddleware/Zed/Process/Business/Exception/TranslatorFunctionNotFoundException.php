<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

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
        $message .= 'Can not resolve ' . $className . ' translation function' . PHP_EOL;
        $message .= 'You can fix this by adding the missing translationFunction to your bundle.' . PHP_EOL;
        $message .= 'E.g. Pyz\\Zed\\Process\\Business\\Translator\\TranslatorFunction\\' . $className . PHP_EOL . PHP_EOL;
        $message .= new Backtrace();

        return $message;
    }
}
