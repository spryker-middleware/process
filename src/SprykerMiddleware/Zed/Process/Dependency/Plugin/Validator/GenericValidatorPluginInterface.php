<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator;

interface GenericValidatorPluginInterface extends ValidatorPluginInterface
{
    /**
     * @api
     *
     * @return string
     */
    public function getValidatorClassName(): string;
}
