<?php

namespace  SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

interface StageInterface
{
    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param mixed $originalPayload
     *
     * @return mixed
     */
    public function __invoke($payload, ReadStreamInterface $inStream, WriteStreamInterface $outStream, $originalPayload): array;

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface
     */
    public function getStagePlugin(): StagePluginInterface;
}
