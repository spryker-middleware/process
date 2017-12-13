<?php


namespace SprykerMiddleware\Zed\Process\Business\PayloadManager;

class PayloadManager implements PayloadManagerInterface
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
    public function setValue(array $payload, string $key, $value): array
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
}
