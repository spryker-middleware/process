<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\ArrayManager;

class ArrayManager implements ArrayManagerInterface
{
    /**
     * @param array $payload
     * @param string $keyString
     *
     * @return mixed
     */
    public function getValueByKey(array $payload, string $keyString)
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
     * @param array $payload
     * @param string $key
     * @param mixed $value
     *
     * @return array
     */
    public function putValue(array $payload, string $key, $value): array
    {
        $keys = explode('.', $key);
        $temp = &$payload;
        foreach ($keys as $key) {
            if (!isset($temp[$key])) {
                $temp[$key] = [];
            }
            $temp = &$temp[$key];
        }
        $temp = $value;

        return $payload;
    }

    /**
     * @param array $payload
     * @param string $key
     *
     * @return array
     */
    public function getAllNestedKeys(array $payload, string $key): array
    {
        $keyParts = explode('.', $key);
        $keyLevel = count($keyParts);
        $keys = [
            reset($keyParts),
        ];
        for ($i = 1; $i < $keyLevel; $i++) {
            if ($keyParts[$i] !== '*') {
                foreach ($keys as $k => $value) {
                    $keys[$k] = implode('.', [$value, $keyParts[$i]]);
                }
                continue;
            }
            $newKeys = [];
            foreach ($keys as $parentKey) {
                $nestedArray = $this->getValueByKey($payload, $parentKey);
                if (!is_array($nestedArray)) {
                    continue;
                }
                $nestedKeys = array_keys($nestedArray);
                foreach ($nestedKeys as $nestedKey) {
                    $newKeys[] = implode('.', [$parentKey, $nestedKey]);
                }
            }
            $keys = $newKeys;
        }

        return $keys;
    }
}
