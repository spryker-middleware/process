<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
