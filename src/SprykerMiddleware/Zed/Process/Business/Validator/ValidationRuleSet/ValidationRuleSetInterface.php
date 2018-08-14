<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet;

use Generated\Shared\Transfer\ValidatorConfigTransfer;

interface ValidationRuleSetInterface
{
    /**
     * @return \Generated\Shared\Transfer\ValidatorConfigTransfer
     */
    public function getValidatorConfig(): ValidatorConfigTransfer;
}
