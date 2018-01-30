<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Processor;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

class FingersCrossedProcessor implements PipelineProcessorInterface
{
    /**
     * @param array $stages
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     *
     * @return mixed
     */
    public function process(array $stages, $payload, ReadStreamInterface $inStream, WriteStreamInterface $outStream)
    {
        foreach ($stages as $stage) {
            $payload = call_user_func($stage, $payload, $inStream, $outStream);
        }

        return $payload;
    }
}
