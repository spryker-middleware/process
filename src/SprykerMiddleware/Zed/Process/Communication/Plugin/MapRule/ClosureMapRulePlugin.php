<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule;

use Closure;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\MapRule\MapRulePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessBusinessFactory getFactory()
 */
class ClosureMapRulePlugin extends AbstractPlugin implements MapRulePluginInterface
{
    /**
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
        return $this->getFacade()->mapByClosure($result, $payload, $key, $value, $strategy);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return bool
     */
    public function isApplicable(string $key, $value): bool
    {
        return $value instanceof Closure;
    }
}
