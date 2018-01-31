<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class FloatToInt extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @param float $value
     * @param array $payload
     *
     * @return int
     */
    public function translate($value, array $payload)
    {
        return (int)$value;
    }
}
