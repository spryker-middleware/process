<?php

namespace SprykerMiddleware\Zed\Process\Business\Writer;

use Psr\Log\LoggerInterface;
use SprykerMiddleware\Service\Process\ProcessServiceInterface;

class JsonWriter implements WriterInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \SprykerMiddleware\Service\Process\ProcessServiceInterface
     */
    protected $streamService;

    /**
     * @param \SprykerMiddleware\Service\Process\ProcessServiceInterface $streamService
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(ProcessServiceInterface $streamService, LoggerInterface $logger)
    {
        $this->logger = $logger;
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
