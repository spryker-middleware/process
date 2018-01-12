<?php

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

interface InputStreamPluginInterface
{
    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function getInputStream(string $path): ReadStreamInterface;
}
