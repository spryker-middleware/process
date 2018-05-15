<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\Resolver;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\ValidatorPluginInterface;

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

interface ValidatorPluginResolverInterface
{
    /**
     * @param string $validatorPluginName
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MissingTranslatorFunctionPluginException
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\ValidatorPluginInterface
     */
    public function getValidatorPluginByName(string $validatorPluginName): ValidatorPluginInterface;
}
