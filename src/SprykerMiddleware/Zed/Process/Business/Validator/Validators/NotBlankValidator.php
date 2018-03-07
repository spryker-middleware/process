<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class NotBlankValidator extends AbstractValidator
{
    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return mixed
     */
    public function validate($value, array $payload): bool
    {
        if (!isset($payload[$this->key]) || $value === null || $value === [] || $value === '') {
            return false;
        }
        return true;
    }
}
