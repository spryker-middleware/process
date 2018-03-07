<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Factory;

use SprykerMiddleware\Zed\Process\Business\Validator\Validators\ValidatorInterface;

class ValidatorFactory implements ValidatorFactoryInterface
{
    /**
     * @param string $validatorClassName
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Validator\Validators\ValidatorInterface
     */
    public function createValidator(string $validatorClassName): ValidatorInterface
    {
        return new $validatorClassName();
    }
}
