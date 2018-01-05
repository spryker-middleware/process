<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\StreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

abstract class AbstractStagePlugin extends AbstractPlugin implements StagePluginInterface
{
    /**
     * @var resource
     */
    protected $inStream;

    /**
     * @var resource
     */
    protected $outStream;

    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    abstract public function process($payload);

    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $inStream
     *
     * @return void
     */
    public function setInStream(StreamInterface $inStream): void
    {
        $this->inStream = $inStream;
    }

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $outStream
     *
     * @return void
     */
    public function setOutStream(StreamInterface $outStream): void
    {
        $this->outStream = $outStream;
    }
}
