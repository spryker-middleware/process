<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Processor;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface PipelineProcessorInterface
{
    /**
     * @param array $stages
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     *
     * @return mixed
     */
    public function process(array $stages, $payload, ReadStreamInterface $inStream, WriteStreamInterface $outStream);
}
