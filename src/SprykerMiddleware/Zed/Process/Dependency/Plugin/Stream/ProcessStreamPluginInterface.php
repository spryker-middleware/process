<?php

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

interface ProcessStreamPluginInterface
{
    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\StreamInterface
     */
    public function getStream(string $path): StreamInterface;

    /**
     * @return string
     */
    public function getProtocol(): string;
}
