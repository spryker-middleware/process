<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Validator;

use SprykerMiddleware\Zed\Process\Business\Validator\Validators\LessOrEqualThanValidator;

class LessOrEqualThanValidatorPlugin extends AbstractGenericValidatorPlugin
{
    public const NAME = 'LessOrEqualThan';

    /**
     * @api
     *
     * @return string
     */
    public function getValidatorClassName(): string
    {
        return LessOrEqualThanValidator::class;
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
