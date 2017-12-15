<?php

namespace SprykerMiddleware\Zed\Process\Business\Mapper;

use SprykerMiddleware\Shared\Process\ProcessConstants;
use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;
use SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface;

class Mapper implements MapperInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface
     */
    protected $map;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface
     */
    protected $payloadManager;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface $map
     * @param \SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface $payloadManager
     */
    public function __construct(MapInterface $map, PayloadManagerInterface $payloadManager)
    {
        $this->map = $map;
        $this->payloadManager = $payloadManager;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function map(array $payload): array
    {
        $result = $this->prepareResult($payload);
        foreach ($this->map->getMap() as $key => $value) {
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
            return $this->payloadManager->setValue($result, $key, $value($payload, $key));
        }
        if (is_array($value)) {
            return $this->mapArray($result, $payload, $key, $value);
        }
        if (is_string($value) || is_int($value)) {
            return $this->payloadManager
                ->setValue($result, $key, $this->payloadManager->getValueByKey($payload, $value));
        }

        return $result;
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

        return $this->payloadManager->setValue($result, $key, $resultArray);
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
        if ($this->map->getStrategy() === ProcessConstants::MAPPER_STRATEGY_COPY_UNKNOWN) {
            return $payload;
        }

        return [];
    }
}
