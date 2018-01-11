<?php

namespace SprykerMiddleware\Service\Process\Model;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

class StreamService implements StreamServiceInterface
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $stream
     *
     * @return array
     */
    public function read(ReadStreamInterface $stream)
    {
        return $stream->read();
    }

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $stream
     * @param array $data
     *
     * @return bool|int
     */
    public function write(WriteStreamInterface $stream, $data)
    {
        return $stream->write($data);
    }
}
