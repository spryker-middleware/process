<?php

namespace SprykerMiddleware\Service\Process\Model;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

interface StreamServiceInterface
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $stream
     *
     * @return mixed
     */
    public function read(StreamInterface $stream);

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $stream
     * @param mixed $data
     *
     * @return mixed
     */
    public function write(StreamInterface $stream, $data);
}
