<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class LengthValidator extends AbstractValidator
{
    public const OPTION_MIN = 'min';
    public const OPTION_MAX = 'max';

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return bool
     */
    public function validate($value, array $payload): bool
    {
        $isValid = true;
        if ($value === null) {
            return true;
        }

        $stringValue = (string)$value;
        $length = mb_strlen($stringValue);

        if ($this->getMinLength() !== null && $length < $this->getMinLength()) {
            $isValid = false;
        }

        if ($this->getMaxLength() !== null && $length > $this->getMaxLength()) {
            $isValid = false;
        }
        return $isValid;
    }

    /**
     * @return int|null
     */
    protected function getMinLength(): ?int
    {
        return $this->options[static::OPTION_MIN];
    }

    /**
     * @return int|null
     */
    protected function getMaxLength(): ?int
    {
        return $this->options[static::OPTION_MAX];
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        parent::setOptions($options);

        if (!isset($this->options[static::OPTION_MIN])) {
            $this->options[static::OPTION_MIN] = null;
        }

        if (!isset($this->options[static::OPTION_MAX])) {
            $this->options[static::OPTION_MAX] = null;
        }

        return $this;
    }
}
