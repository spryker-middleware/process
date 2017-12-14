<?php

namespace SprykerMiddleware\Zed\Process\Business\Writer;

class Writer implements WriterInterface
{
    /**
     * @param array $payload
     *
     * @return array
     */
    public function write(array $payload, string $destination): array
    {
        file_put_contents($destination, var_export($payload, true));

        return $payload;
    }
}
