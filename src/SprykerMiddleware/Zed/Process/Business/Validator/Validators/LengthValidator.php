<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class LengthValidator extends AbstractValidator
{
    const OPTION_MIN = 'min';
    const OPTION_MAX = 'max';

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return mixed
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
     * @return int
     */
    protected function getMinLength(): int
    {
        return $this->options[static::OPTION_MIN];
    }

    /**
     * @return int
     */
    protected function getMaxLength(): int
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
