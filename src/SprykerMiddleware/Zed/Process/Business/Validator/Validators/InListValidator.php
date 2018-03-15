<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class InListValidator extends AbstractValidator
{
    const OPTION_VALUES = 'values';

    /**
     * @var array
     */
    protected $requiredOptions = [self::OPTION_VALUES];

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
