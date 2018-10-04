<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class TranslatorFunctionFactory implements TranslatorFunctionFactoryInterface
{
    /**
     * @var array
     */
    protected static $translatorFunctionCache = [];

    /**
     * @param string $translatorFunctionClassName
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface
     */
    public function createTranslatorFunction(string $translatorFunctionClassName): TranslatorFunctionInterface
    {
        if (!isset(static::$translatorFunctionCache[$translatorFunctionClassName])) {
            static::$translatorFunctionCache[$translatorFunctionClassName] = new $translatorFunctionClassName();
        }

        return static::$translatorFunctionCache[$translatorFunctionClassName];
    }
}
