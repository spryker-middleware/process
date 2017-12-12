<?php

namespace SprykerMiddleware\Zed\Process\Business\Mapper;

class Mapper implements MapperInterface
{
    /**
     * @var array
     */
    protected $map;

    /**
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function map(array $payload): array
    {
        $result = [];
        foreach ($this->map as $key => $value) {
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
            return $this->setValue($result, $key, $value($payload));
        }
        if (is_array($value)) {
            return $this->mapArray($result, $payload, $key, $value);
        }
        if (is_string($value) || is_int($value)) {
            return $this->setValue($result, $key, $this->getValueByKey($payload, $value));
        }

        return $result;
    }

    /**
     * @param array $result
     * @param string $key
     * @param mixed $value
     *
     * @return array
     */
    protected function setValue(array $result, string $key, $value): array
    {
        $keys = explode('.', $key);
        $temp = &$result;
        foreach ($keys as $key) {
            if (!isset($temp[$key])) {
                $temp[$key] = [];
            }
            $temp = &$temp[$key];
        }
        $temp = $value;

        return $result;
    }

    /**
     * @param mixed $payload
     * @param string $keyString
     *
     * @return mixed
     */
    private function getValueByKey($payload, string $keyString)
    {
        $keys = explode('.', $keyString);
        $value = $payload;
        foreach ($keys as $key) {
            if (!isset($value[$key])) {
                return null;
            }
            $value = $value[$key];
        }

        return $value;
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
        $originArray = $this->getValueByKey($payload, $originKey);
        $originArray = $this->filterArray($originArray, $value);
        if (!isset($value['itemMap'])) {
            return $this->setValue($result, $key, $originArray);
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

        return $this->setValue($result, $key, $resultArray);
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
}
