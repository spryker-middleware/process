<?php

namespace SprykerMiddleware\Zed\Process\Business\Reader;

use Psr\Log\LoggerInterface;
use SprykerMiddleware\Service\Process\ProcessServiceInterface;

class JsonReader implements ReaderInterface
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
     * @param resource $inStream
     *
     * @return array
     */
    public function read($inStream): array
    {
        return $this->streamService
            ->readJson($inStream);
    }
}
