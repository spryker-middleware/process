<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Validator;

use SprykerMiddleware\Zed\Process\Business\Validator\Validators\NotEqualToValidator;

class NotEqualToValidatorPlugin extends AbstractGenericValidatorPlugin
{
    const NAME = 'NotEqualTo';

    /**
     * @return string
     */
    public function getValidatorClassName(): string
    {
        return NotEqualToValidator::class;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }
}
