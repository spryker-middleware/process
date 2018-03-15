<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class TypeValidator extends AbstractValidator
{
    const OPTION_TYPE = 'type';

    /**
     * @var array
     */
    protected $requiredOptions = [self::OPTION_TYPE];

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

        $type = strtolower($this->getType());
        $type = $type == 'boolean' ? 'bool' : $type;
        $isFunction = 'is_' . $type;
        $ctypeFunction = 'ctype_' . $type;

        if (function_exists($isFunction) && $isFunction($value)) {
            return true;
        }

        if (function_exists($ctypeFunction) && $ctypeFunction($value)) {
            return true;
        }

        $type = $this->getType();
        if ($value instanceof $type) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    protected function getType()
    {
        return $this->options[static::OPTION_TYPE];
    }
}
