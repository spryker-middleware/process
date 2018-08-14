<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Validator;

use SprykerMiddleware\Zed\Process\Business\Validator\Validators\RegexValidator;

class RegexValidatorPlugin extends AbstractGenericValidatorPlugin
{
    public const NAME = 'Regex';

    /**
     * @return string
     */
    public function getValidatorClassName(): string
    {
        return RegexValidator::class;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }
}
