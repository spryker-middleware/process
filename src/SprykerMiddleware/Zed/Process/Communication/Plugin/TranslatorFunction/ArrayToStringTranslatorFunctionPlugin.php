<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\ArrayToString;

/**
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class ArrayToStringTranslatorFunctionPlugin extends AbstractGenericTranslatorFunctionPlugin
{
    public const NAME = 'ArrayToString';

    /**
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getTranslatorFunctionClassName(): string
    {
        return ArrayToString::class;
    }
}
