<?php
namespace SprykerMiddleware\Zed\Process\Dependency\Plugin;

interface StagePluginInterface
{
    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload);

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
