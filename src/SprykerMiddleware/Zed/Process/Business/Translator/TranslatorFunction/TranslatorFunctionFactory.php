<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
