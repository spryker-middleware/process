<?php
namespace SprykerMiddleware\Zed\Process\Dependency\Plugin;

use Psr\Log\LoggerInterface;

interface StagePluginInterface
{
    /**
     * Process the payload.
     *
     * @param mixed $payload
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return mixed
     */
    public function process($payload, LoggerInterface $logger);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param resource $inStream
     *
     * @return void
     */
    public function setInStream($inStream): void;

    /**
     * @param resource $outStream
     *
     * @return void
     */
    public function setOutStream($outStream): void;
}
