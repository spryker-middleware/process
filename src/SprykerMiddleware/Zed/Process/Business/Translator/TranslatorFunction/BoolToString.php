<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class BoolToString extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @param bool $value
     * @param array $payload
     *
     * @return string
     */
    public function translate($value, array $payload)
    {
        return $value ? 'true' : 'false';
    }
}
