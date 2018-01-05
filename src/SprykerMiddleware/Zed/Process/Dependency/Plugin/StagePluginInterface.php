<?php
namespace SprykerMiddleware\Zed\Process\Dependency\Plugin;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

interface StagePluginInterface
{
    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $inStream
     *
     * @return void
     */
    public function setInStream(StreamInterface $inStream): void;

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $outStream
     *
     * @return void
     */
    public function setOutStream(StreamInterface $outStream): void;
}
