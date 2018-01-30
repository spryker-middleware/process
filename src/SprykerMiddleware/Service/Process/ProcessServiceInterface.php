<?php

namespace SprykerMiddleware\Service\Process;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface ProcessServiceInterface
{
    /**
     * Specification:
     * - Read data from given stream.
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $stream
     *
     * @return array
     */
    public function read(ReadStreamInterface $stream);

    /**
     * Specification:
     * - Write given data to given stream.
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $stream
     * @param array $data
     *
     * @return bool|int
     */
    public function write(WriteStreamInterface $stream, $data);
}
