<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

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
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $outStream
     *
     * @return mixed
     */
    public function process($payload, StreamInterface $inStream, StreamInterface $outStream);

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $outStream
     *
     * @return mixed
     */
    public function __invoke($payload, StreamInterface $inStream, StreamInterface $outStream);
}
