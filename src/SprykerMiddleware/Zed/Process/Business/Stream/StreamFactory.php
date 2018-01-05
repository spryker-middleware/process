<?php

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

class StreamFactory
{
    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\StreamInterface
     */
    public function createJsonStream(string $path): StreamInterface
    {
        return new JsonStream($path);
    }
}
