<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class NotBlankValidator extends AbstractValidator
{
    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return bool
     */
    public function validate($value, array $payload): bool
    {
        if ($value === null || $value === [] || $value === '') {
            return false;
        }
        return true;
    }
}
