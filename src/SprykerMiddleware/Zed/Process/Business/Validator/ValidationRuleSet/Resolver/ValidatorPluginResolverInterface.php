<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\Resolver;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\ValidatorPluginInterface;

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
