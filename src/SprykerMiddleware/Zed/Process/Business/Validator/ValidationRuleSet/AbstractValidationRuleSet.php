<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
