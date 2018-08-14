<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet;

use Generated\Shared\Transfer\ValidatorConfigTransfer;

abstract class AbstractValidationRuleSet implements ValidationRuleSetInterface
{
    /**
     * @return \Generated\Shared\Transfer\ValidatorConfigTransfer
     */
    public function getValidatorConfig(): ValidatorConfigTransfer
    {
        $validatorConfigTransfer = new ValidatorConfigTransfer();
        $validatorConfigTransfer->setRules($this->getRules());

        return $validatorConfigTransfer;
    }

    /**
     * @return array
     */
    abstract protected function getRules(): array;
}
