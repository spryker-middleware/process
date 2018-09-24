<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class RegexValidator extends AbstractValidator
{
    public const OPTION_PATTERN = 'pattern';

    /**
     * @var array
     */
    protected $requiredOptions = [self::OPTION_PATTERN];

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return bool
     */
    public function validate($value, array $payload): bool
    {
        $isValid = !is_array($value) && preg_match($this->getPattern(), $value);

        return $isValid;
    }

    /**
     * @return string
     */
    protected function getPattern(): string
    {
        return $this->options[static::OPTION_PATTERN];
    }
}
