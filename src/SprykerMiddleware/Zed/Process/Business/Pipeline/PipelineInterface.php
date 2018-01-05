<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

interface PipelineInterface
{
    /**
     * Create a new pipeline with an appended stage.
     *
     * @param callable $operation
     *
     * @return static
     */
    public function pipe(callable $operation);

    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload);

    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function __invoke($payload);

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $inputStream
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $outputStream
     *
     * @return void
     */
    public function setStreams(StreamInterface $inputStream, StreamInterface $outputStream);
}
