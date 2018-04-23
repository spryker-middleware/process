<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper;

use SprykerMiddleware\Shared\Logger\Logger\MiddlewareLoggerTrait;

class ClosureMapper extends AbstractMapper
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
        $mappedValue = $value($payload, $key);

        $this->getProcessLogger()->debug(static::OPERATION, [
            static::KEY_OPERATION => static::OPERATION_MAP_CALLABLE,
            static::KEY_NEW_KEY => $key,
            static::KEY_OLD_KEY => $value,
            static::KEY_DATA => $mappedValue,
        ]);

        return $this->arrayManager->putValue($result, $key, $mappedValue);
    }
}
