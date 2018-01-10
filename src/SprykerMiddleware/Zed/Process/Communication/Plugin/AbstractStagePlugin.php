<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\StreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

abstract class AbstractStagePlugin extends AbstractPlugin implements StagePluginInterface
{
    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $outStream
     *
     * @return mixed
     */
    abstract public function process($payload, StreamInterface $inStream, StreamInterface $outStream);

    /**
     * @return string
     */
    abstract public function getName(): string;
}
