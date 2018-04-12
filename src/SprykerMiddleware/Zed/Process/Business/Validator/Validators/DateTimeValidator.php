<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

use DateTime;
use DateTimeInterface;

class DateTimeValidator extends AbstractValidator
{
    public const OPTION_FORMAT = 'format';
    public const DEFAULT_FORMAT = 'Y-m-d H:i:s';

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return bool
     */
    public function validate($value, array $payload): bool
    {
        if ($value === null || $value === '' || $value instanceof DateTimeInterface) {
            return true;
        }

        $value = (string)$value;
        DateTime::createFromFormat($this->getFormat(), $value);
        $errors = DateTime::getLastErrors();
        if ($errors['error_count'] > 0) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    protected function getFormat(): string
    {
        if (isset($this->options[static::OPTION_FORMAT])) {
            return $this->options[static::OPTION_FORMAT];
        }

        return static::DEFAULT_FORMAT;
    }
}
