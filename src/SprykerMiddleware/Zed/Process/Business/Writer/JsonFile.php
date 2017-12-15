<?php

namespace SprykerMiddleware\Zed\Process\Business\Writer;

class JsonFile implements WriterInterface
{
    /**
     * @param array $payload
     * @param string $destination
     *
     * @return array
     */
    public function write(array $payload, string $destination): array
    {
        file_put_contents($destination, json_encode($payload));

        return $payload;
    }
}
