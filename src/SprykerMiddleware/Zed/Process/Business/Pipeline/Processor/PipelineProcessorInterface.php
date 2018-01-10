<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Processor;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

interface PipelineProcessorInterface
{
    /**
     * @param array $stages
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $outStream
     *
     * @return mixed
     */
    public function process(array $stages, $payload, StreamInterface $inStream, StreamInterface $outStream);
}
