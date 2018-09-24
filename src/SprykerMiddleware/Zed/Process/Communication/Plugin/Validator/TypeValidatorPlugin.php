<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Validator;

use SprykerMiddleware\Zed\Process\Business\Validator\Validators\TypeValidator;

class TypeValidatorPlugin extends AbstractGenericValidatorPlugin
{
    public const NAME = 'Type';

    /**
     * @api
     *
     * @return string
     */
    public function getValidatorClassName(): string
    {
        return TypeValidator::class;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }
}
