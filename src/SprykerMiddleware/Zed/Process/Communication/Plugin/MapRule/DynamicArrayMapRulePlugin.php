<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Logger\Logger\MiddlewareLoggerTrait;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\MapRule\MapRulePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessBusinessFactory getFactory()
 */
class DynamicArrayMapRulePlugin extends AbstractPlugin implements MapRulePluginInterface
{
    use MiddlewareLoggerTrait;

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $value
     *
     * @return array
     */
    public function map(array $result, array $payload, string $key, $value): array
    {
        return $this->getFacade()->mapByDynamicArray($result, $payload, $key, $value);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return bool
     */
    public function isApplicable(string $key, $value): bool
    {
        return is_array($value);
    }
}
