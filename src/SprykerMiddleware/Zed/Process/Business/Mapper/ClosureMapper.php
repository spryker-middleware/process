<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper;

class ClosureMapper extends AbstractMapper
{
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
        $mappedValue = $value($payload, $key);

        $this->log(static::OPERATION, static::OPERATION_MAP_CALLABLE, $key, $value, $mappedValue);

        return $this->arrayManager->putValue($result, $key, $mappedValue);
    }
}
