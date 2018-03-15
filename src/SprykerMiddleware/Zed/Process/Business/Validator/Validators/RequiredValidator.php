<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class RequiredValidator extends AbstractValidator
{
    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return mixed
     */
    public function validate($value, array $payload): bool
    {
        if ($value === null) {
            return false;
        }

        return true;
    }
}
