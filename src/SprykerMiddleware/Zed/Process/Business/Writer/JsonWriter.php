<?php

namespace SprykerMiddleware\Zed\Process\Business\Writer;

use Psr\Log\LoggerInterface;

class JsonWriter implements WriterInterface
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var resource
     */
    protected $outStream;

    /**
     * @param resource
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct($outStream, LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param mixed $payload
     *
     * @return mixed
     */
    public function write($payload)
    {
        fwrite($this->outStream, json_encode($payload));
    }
}
