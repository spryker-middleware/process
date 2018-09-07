<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\MapRule;

interface MapRulePluginInterface
{
    public const OPTION_ITEM_MAP = 'itemMap';
    public const OPTION_SELF_REFERENCE_MAP = 'selfReferenceMap';
    public const OPTION_DYNAMIC_IDENTIFIER = '&';

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
    public function map(array $result, array $payload, string $key, $value, string $strategy): array;

    /**
     * @api
     *
     * @param string $key
     * @param mixed $value
     *
     * @return bool
     */
    public function isApplicable(string $key, $value): bool;
}
