<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Stream;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\StreamInterface;
use SprykerMiddleware\Zed\Process\Business\StreamWrapper\JsonStreamWrapper;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\ProcessStreamPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class JsonStreamPlugin extends AbstractPlugin implements ProcessStreamPluginInterface
{
    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\StreamInterface
     */
    public function getStream(string $path): StreamInterface
    {
         return $this->getFactory()
            ->createStreamFactory()
            ->createJsonStream($path);
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return JsonStreamWrapper::STREAM_PROTOCOL;
    }
}
