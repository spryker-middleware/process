<?php

namespace SprykerMiddleware\Zed\Process\Business\Writer;

use SprykerMiddleware\Service\Process\ProcessServiceInterface;

class JsonWriter implements WriterInterface
{
    /**
     * @var \SprykerMiddleware\Service\Process\ProcessServiceInterface
     */
    protected $streamService;

    /**
     * @param \SprykerMiddleware\Service\Process\ProcessServiceInterface $streamService
     */
    public function __construct(ProcessServiceInterface $streamService)
    {
        $this->streamService = $streamService;
    }

    /**
     * @param resource $outStream
     * @param mixed $payload
     *
     * @return bool|int
     */
    public function write($outStream, $payload)
    {
        return $this->streamService->writeJson($outStream, $payload);
    }
}
