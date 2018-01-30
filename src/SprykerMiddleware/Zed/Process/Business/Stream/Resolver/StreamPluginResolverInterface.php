<?php

namespace SprykerMiddleware\Zed\Process\Business\Stream\Resolver;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\ProcessStreamPluginInterface;

interface StreamPluginResolverInterface
{
    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\ProcessStreamPluginInterface
     */
    public function getStreamPluginByPath(string $path): ProcessStreamPluginInterface;
}
