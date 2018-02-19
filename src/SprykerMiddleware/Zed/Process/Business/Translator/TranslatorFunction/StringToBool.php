<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class StringToBool extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    const VALUE_TRUE = 'true';
    /**
     * @param string $value
     * @param array $payload
     *
     * @return bool
     */
    public function translate($value, array $payload): bool
    {
        return strtolower($value) === static::VALUE_TRUE;
    }
}
