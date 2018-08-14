<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper;

class KeyMapper extends AbstractMapper
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
        $mappedValue = $this->arrayManager->getValueByKey($payload, $value);

        $this->log(static::OPERATION, static::OPERATION_MAP_KEY, $key, $value, $mappedValue);

        return $this->arrayManager->putValue($result, $key, $mappedValue);
    }
}
