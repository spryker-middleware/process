<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface PipelineInterface
{
    /**
     * @param callable $operation
     *
     * @return static
     */
    public function pipe(callable $operation);

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     *
     * @return mixed
     */
    public function process($payload, ReadStreamInterface $inStream, WriteStreamInterface $outStream);

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     *
     * @return mixed
     */
    public function __invoke($payload, ReadStreamInterface $inStream, WriteStreamInterface $outStream);
}
