<?php

namespace SprykerMiddleware\Zed\Process\Business\Writer;

class SerializedDump implements WriterInterface
{
    /**
     * @param array $payload
     * @param string $destination
     *
     * @return array
     */
    public function write(array $payload, string $destination): array
    {
        file_put_contents($destination, serialize($payload));

        return $payload;
    }
}
