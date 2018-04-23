<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper;

use SprykerMiddleware\Shared\Logger\Logger\MiddlewareLoggerTrait;

class KeyMapper extends AbstractMapper
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
        $mappedValue = $this->arrayManager->getValueByKey($payload, $value);
        $this->getProcessLogger()->debug(static::OPERATION, [
            static::KEY_OPERATION => static::OPERATION_MAP_KEY,
            static::KEY_NEW_KEY => $key,
            static::KEY_OLD_KEY => $value,
            static::KEY_DATA => $mappedValue,
        ]);

        return $this->arrayManager->putValue($result, $key, $mappedValue);
    }
}
