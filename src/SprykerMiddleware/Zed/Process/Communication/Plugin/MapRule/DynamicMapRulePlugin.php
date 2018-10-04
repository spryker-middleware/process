<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\MapRule\MapRulePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessBusinessFactory getFactory()
 */
class DynamicMapRulePlugin extends AbstractPlugin implements MapRulePluginInterface
{
    /**
     * @api
     *
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $value
     * @param string $strategy
     *
     * @return array
     */
    public function map(array $result, array $payload, string $key, $value, string $strategy): array
    {
        return $this->getFacade()->mapByDynamic($result, $payload, $key, $value, $strategy);
    }

    /**
     * @api
     *
     * @param string $key
     * @param mixed $value
     *
     * @return bool
     */
    public function isApplicable(string $key, $value): bool
    {
        return strpos($key, static::OPTION_DYNAMIC_IDENTIFIER) === 0;
    }
}
