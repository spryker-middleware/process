<?php

namespace SprykerMiddleware\Service\Process;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

interface ProcessServiceInterface
{
    /**
     * Specification:
     * - Read data from given JSON stream.
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $stream
     *
     * @return array
     */
    public function readJson(StreamInterface $stream);

    /**
     * Specification:
     * - Write given data to given JSON stream.
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $stream
     * @param array $data
     *
     * @return bool|int
     */
    public function writeJson(StreamInterface $stream, $data);
}
