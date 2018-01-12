<?php

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream;

use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface OutputStreamPluginInterface
{
    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function getOutputStream(string $path): WriteStreamInterface;
}
