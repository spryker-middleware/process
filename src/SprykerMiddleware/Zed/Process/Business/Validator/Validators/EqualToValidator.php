<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class EqualToValidator extends AbstractValidator
{
    public const OPTION_VALUE = 'value';

    /**
     * @var array
     */
    protected $requiredOptions = [self::OPTION_VALUE];

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return bool
     */
    public function validate($value, array $payload): bool
    {
        return $value == $this->getValue();
    }

    /**
     * @return mixed
     */
    protected function getValue()
    {
        return $this->options[static::OPTION_VALUE];
    }
}
