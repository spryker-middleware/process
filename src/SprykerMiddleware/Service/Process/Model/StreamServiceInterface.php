<?php

namespace SprykerMiddleware\Service\Process\Model;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

interface StreamServiceInterface
{
    /**
     * Specification:
     * - Read data from given stream.
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $stream
     *
     * @return mixed
     */
    public function read(StreamInterface $stream);

    /**
     * Specification:
     * - Write given data to given stream.
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $stream
     * @param mixed $data
     *
     * @return mixed
     */
    public function write(StreamInterface $stream, $data);
}
