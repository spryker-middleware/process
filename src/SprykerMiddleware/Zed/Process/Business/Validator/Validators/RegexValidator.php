<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class RegexValidator extends AbstractValidator
{
    const OPTION_PATTERN = 'pattern';

    /**
     * @var array
     */
    protected $requiredOptions = [self::OPTION_PATTERN];

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return mixed
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
