<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\MapRule;

interface MapRulePluginInterface
{
    public const OPTION_ITEM_MAP = 'itemMap';
    public const OPTION_SELF_REFERENCE_MAP = 'selfReferenceMap';
    public const OPTION_DYNAMIC_IDENTIFIER = '&';

    /**
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
     * @param string $key
     * @param mixed $value
     *
     * @return bool
     */
    public function isApplicable(string $key, $value): bool;
}
