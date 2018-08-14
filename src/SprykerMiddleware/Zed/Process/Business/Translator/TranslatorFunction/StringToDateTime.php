<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use DateTime;

class StringToDateTime extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @param string $value
     * @param array $payload
     *
     * @return \DateTime
     */
    public function translate($value, array $payload): DateTime
    {
        return new DateTime($value);
    }
}
