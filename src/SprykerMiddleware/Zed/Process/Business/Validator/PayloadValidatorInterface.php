<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
