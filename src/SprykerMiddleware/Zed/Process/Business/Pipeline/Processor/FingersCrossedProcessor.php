<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Processor;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

class FingersCrossedProcessor implements PipelineProcessorInterface
{
    /**
     * @param array $stages
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $outStream
     *
     * @return mixed
     */
    public function process(array $stages, $payload, StreamInterface $inStream, StreamInterface $outStream)
    {
        foreach ($stages as $stage) {
            $payload = call_user_func($stage, $payload, $inStream, $outStream);
        }

        return $payload;
    }
}
