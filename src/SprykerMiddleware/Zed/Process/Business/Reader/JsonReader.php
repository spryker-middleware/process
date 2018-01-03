<?php

namespace SprykerMiddleware\Zed\Process\Business\Reader;

use SprykerMiddleware\Service\Process\ProcessServiceInterface;

class JsonReader implements ReaderInterface
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
