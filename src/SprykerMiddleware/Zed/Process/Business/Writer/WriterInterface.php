<?php

namespace SprykerMiddleware\Zed\Process\Business\Writer;

interface WriterInterface
{
    /**
     * @param array $payload
     *
     * @return array
     */
    public function write(array $payload, string $destination): array;
}
