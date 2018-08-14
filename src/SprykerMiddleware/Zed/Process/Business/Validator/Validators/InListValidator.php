<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class InListValidator extends AbstractValidator
{
    public const OPTION_VALUES = 'values';

    /**
     * @var array
     */
    protected $requiredOptions = [self::OPTION_VALUES];

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return bool
     */
    public function validate($value, array $payload): bool
    {
        if ($value === null) {
            return true;
        }

        return in_array($value, $this->getValues());
    }

    /**
     * @return array
     */
    protected function getValues(): array
    {
        return $this->options[static::OPTION_VALUES];
    }
}
