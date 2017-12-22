<?php

namespace SprykerMiddleware\Zed\Process\Business\Reader;

use Psr\Log\LoggerInterface;

class JsonReader implements ReaderInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * JsonReader constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param resource $inStream
     *
     * @return array
     */
    public function read($inStream): array
    {
        return json_decode(fgets($inStream), 1);
    }
}
