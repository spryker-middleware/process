<?php

namespace SprykerMiddleware\Service\Process\Model;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

class JsonStreamService implements JsonStreamServiceInterface
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $stream
     *
     * @return array
     */
    public function read(StreamInterface $stream)
    {
        $data = $stream->get();
        return json_decode($data, true);
    }

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $stream
     * @param array $data
     *
     * @return bool|int
     */
    public function write(StreamInterface $stream, $data)
    {
        $data = json_encode($data);
        return $stream->write($data);
    }
}
