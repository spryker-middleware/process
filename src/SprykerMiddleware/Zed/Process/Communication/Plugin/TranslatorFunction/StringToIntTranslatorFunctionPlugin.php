<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\StringToInt;

class StringToIntTranslatorFunctionPlugin extends AbstractTranslatorFunctionPlugin
{
    const NAME = 'StringToInt';
    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public function getTranslatorFunctionClassName()
    {
        return StringToInt::class;
    }
}
