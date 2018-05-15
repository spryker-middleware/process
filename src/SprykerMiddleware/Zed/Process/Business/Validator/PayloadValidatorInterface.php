<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator;

use Generated\Shared\Transfer\ValidatorConfigTransfer;

interface PayloadValidatorInterface
{
    /**
     * @param array $payload
     * @param \Generated\Shared\Transfer\ValidatorConfigTransfer $validatorConfigTransfer
     *
     * @return array
     */
    public function validate(array $payload, ValidatorConfigTransfer $validatorConfigTransfer): array;
}
