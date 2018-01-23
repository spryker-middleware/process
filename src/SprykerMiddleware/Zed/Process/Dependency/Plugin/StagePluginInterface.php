<?php
namespace SprykerMiddleware\Zed\Process\Dependency\Plugin;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface StagePluginInterface
{
    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param mixed $originalPayload
     *
     * @return mixed
     */
    public function process($payload, ReadStreamInterface $inStream, WriteStreamInterface $outStream, $originalPayload);
}
