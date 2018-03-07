<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class LessOrEqualThanValidator extends AbstractValidator
{
    const OPTION_VALUE = 'value';

    /**
     * @var array
     */
    protected $requiredOptions = [self::OPTION_VALUE];

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return mixed
     */
    public function validate($value, array $payload): bool
    {
        if ($value === null) {
            return true;
        }

        return $value <= $this->getValue();
    }

    /**
     * @return mixed
     */
    protected function getValue()
    {
        return $this->options[static::OPTION_VALUE];
    }
}
