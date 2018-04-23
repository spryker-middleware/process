<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper;

use SprykerMiddleware\Zed\Process\Business\Exception\InvalidReferenceException;

class DynamicMapper extends AbstractMapper
{
    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $value
     * @param string $strategy
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\InvalidReferenceException
     *
     * @return array
     */
    public function map(array $result, array $payload, string $key, $value, string $strategy): array
    {
        $mappedValue = $this->arrayManager->getValueByKey($payload, $value);
        $reference = explode(static::OPTION_DYNAMIC_IDENTIFIER, $key)[1];
        $neededKey = $this->arrayManager->getValueByKey($payload, $reference);

        if (!$neededKey) {
            throw new InvalidReferenceException(sprintf('%s key does not exist in payload.', $reference));
        }

        $this->log(static::OPERATION, static::OPERATION_MAP_DYNAMIC, $neededKey, $value, $mappedValue);

        return $this->arrayManager->putValue($result, $neededKey, $mappedValue);
    }
}
