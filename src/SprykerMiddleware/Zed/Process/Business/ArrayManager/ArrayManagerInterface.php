<?php


namespace SprykerMiddleware\Zed\Process\Business\ArrayManager;

interface ArrayManagerInterface
{
    /**
     * @param array $payload
     * @param string $keyString
     *
     * @return mixed
     */
    public function getValueByKey(array $payload, string $keyString);

    /**
     * @param array $payload
     * @param string $key
     * @param mixed $value
     *
     * @return array
     */
    public function putValue(array $payload, string $key, $value): array;

    /**
     * @param array $payload
     * @param string $key
     *
     * @return array
     */
    public function getAllNestedKeys(array $payload, string $key): array;
}
