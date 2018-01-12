<?php

namespace SprykerMiddleware\Zed\Process\Business\Stream;

class StreamFactory
{
    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface|\SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createJsonStream(string $path)
    {
        return new JsonStream($path);
    }
}
