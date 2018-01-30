<?php

namespace SprykerMiddleware\Service\Process\Model;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface StreamServiceInterface
{
    /**
     * Specification:
     * - Read data from given stream.
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $stream
     *
     * @return mixed
     */
    public function read(ReadStreamInterface $stream);

    /**
     * Specification:
     * - Write given data to given stream.
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $stream
     * @param mixed $data
     *
     * @return mixed
     */
    public function write(WriteStreamInterface $stream, $data);
}
