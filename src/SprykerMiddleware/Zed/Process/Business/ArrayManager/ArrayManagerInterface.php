<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\ArrayManager;

interface ArrayManagerInterface
{
    /**
     * @param array $payload
     * @param string $keyString
     *
     * @return mixed
     */
    public function getValueByKey(array $payload, string $keyString);

    /**
     * @param array $payload
     * @param string $key
     * @param mixed $value
     *
     * @return array
     */
    public function putValue(array $payload, string $key, $value): array;

    /**
     * @param array $payload
     * @param string $key
     *
     * @return array
     */
    public function getAllNestedKeys(array $payload, string $key): array;
}
