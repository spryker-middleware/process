<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
