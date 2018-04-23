<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
//        if (!$value instanceof \Closure) {
//            var_dump($key, $value);
//            var_dump(is_array($value));
//        }
        return is_array($value);
    }
}
