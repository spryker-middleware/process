<?php

namespace SprykerMiddleware\Zed\Process\Business\Mapper;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Psr\Log\LoggerInterface;
use SprykerMiddleware\Shared\Process\Config\ProcessConfig;
use SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface;

class Mapper implements MapperInterface
{
    /**
     * @var \Generated\Shared\Transfer\MapperConfigTransfer
     */
    protected $mapperConfigTransfer;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface
     */
    protected $payloadManager;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Generated\Shared\Transfer\MapperConfigTransfer $mapperConfigTransfer
     * @param \SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface $payloadManager
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        MapperConfigTransfer $mapperConfigTransfer,
        PayloadManagerInterface $payloadManager,
        LoggerInterface $logger
    ) {
        $this->mapperConfigTransfer = $mapperConfigTransfer;
        $this->payloadManager = $payloadManager;
        $this->logger = $logger;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function map(array $payload): array
    {
        $result = $this->prepareResult($payload);
        foreach ($this->mapperConfigTransfer->getMap() as $key => $value) {
            $result = $this->mapByRule($result, $payload, $key, $value);
        }

        return $result;
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $value
     *
     * @return array
     */
    protected function mapByRule(array $result, array $payload, string $key, $value): array
    {
        if (is_callable($value)) {
            return $this->mapCallable($result, $payload, $key, $value);
        }
        if (is_array($value)) {
            return $this->mapArray($result, $payload, $key, $value);
        }
        if (is_string($value) || is_int($value)) {
            return $this->mapKey($result, $payload, $key, $value);
        }

        return $result;
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param callable $value
     *
     * @return array
     */
    protected function mapCallable(array $result, array $payload, string $key, callable $value): array
    {
        $mappedValue = $value($payload, $key);
        $this->logger->debug('Mapping', [
            'operation' => 'Map callable',
            'new_key' => $key,
            'old_key' => $value,
            'data' => $mappedValue,
        ]);
        return $this->payloadManager->setValue($result, $key, $mappedValue);
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param array $value
     *
     * @return array
     */
    protected function mapArray(array $result, array $payload, string $key, array $value): array
    {
        $originKey = reset($value);
        $originArray = $this->payloadManager->getValueByKey($payload, $originKey);
        $originArray = $this->filterArray($originArray, $value);
        if (!isset($value['itemMap'])) {
            return $this->payloadManager->setValue($result, $key, $originArray);
        }
        $resultArray = [];
        $rules = $value['itemMap'];
        foreach ($originArray as $originItemKey => $item) {
            $resultItem = [];
            foreach ($rules as $itemKey => $itemValue) {
                $resultItem = $this->mapByRule($resultItem, $item, $itemKey, $itemValue);
            }
            $resultArray[$originItemKey] = $resultItem;
        }
        $this->logger->debug('Mapping', [
            'operation' => 'Map array',
            'new_key' => $key,
            'old_key' => $value,
            'data' => $resultArray,
        ]);
        return $this->payloadManager->setValue($result, $key, $resultArray);
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param string $value
     *
     * @return array
     */
    protected function mapKey(array $result, array $payload, string $key, string $value): array
    {
        $mappedValue = $this->payloadManager->getValueByKey($payload, $value);
        $this->logger->debug('Mapping', [
            'operation' => 'Map key',
            'new_key' => $key,
            'old_key' => $value,
            'data' => $mappedValue,
        ]);
        return $this->payloadManager->setValue($result, $key, $mappedValue);
    }

    /**
     * @param array $array
     * @param array $value
     *
     * @return array
     */
    protected function filterArray(array $array, array $value): array
    {
        if (!isset($value['except'])) {
            return $array;
        }

        $exceptKeys = $value['except'];
        if (!is_array($exceptKeys)) {
            $exceptKeys = [$exceptKeys];
        }

        return array_diff_key($array, array_flip($exceptKeys));
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    protected function prepareResult(array $payload): array
    {
        if ($this->mapperConfigTransfer->getStrategy() === ProcessConfig::MAPPER_STRATEGY_COPY_UNKNOWN) {
            $this->logger->debug('Mapping', [
                'operation' => 'Copy original data',
                'strategy' => $this->map->getStrategy(),
            ]);
            return $payload;
        }

        return [];
    }
}
