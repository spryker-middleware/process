<?php

namespace SprykerMiddleware\Zed\Process\Business\Stream\Resolver;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\ProcessStreamPluginInterface;

class StreamPluginResolver implements StreamPluginResolverInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\ProcessStreamPluginInterface[]
     */
    protected $streamPluginStack;

    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\ProcessStreamPluginInterface[] $streamPluginStack
     */
    public function __construct(array $streamPluginStack)
    {
        $this->streamPluginStack = $streamPluginStack;
    }

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\ProcessStreamPluginInterface
     */
    public function getStreamPluginByPath(string $path): ProcessStreamPluginInterface
    {
        $protocol = $this->getProtocol($path);
        return $this->findPluginByProtocol($protocol);
    }

    /**
     * @param string $path
     *
     * @return string|null
     */
    protected function getProtocol(string $path): string
    {
        return parse_url($path, PHP_URL_SCHEME);
    }

    /**
     * @param string $protocol
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\ProcessStreamPluginInterface
     */
    protected function findPluginByProtocol($protocol): ProcessStreamPluginInterface
    {
        foreach ($this->streamPluginStack as $streamPlugin) {
//            if ($streamPlugin->getProtocol() === $protocol) {
                return $streamPlugin;
//            }
        }
    }
}
