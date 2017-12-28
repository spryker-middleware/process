<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

abstract class AbstractStagePlugin extends AbstractPlugin implements StagePluginInterface
{
    const PLUGIN_NAME = 'SPRYKER_MIDDLEWARE_ABSTRACT_STAGE_PLUGIN';

    /**
     * @var resource
     */
    protected $inStream;

    /**
     * @var resource
     */
    protected $outStream;

    /**
     * Process the payload.
     *
     * @param mixed $payload
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return mixed
     */
    abstract public function process($payload, LoggerInterface $logger);

    /**
     * @param resource $inStream
     *
     * @return void
     */
    public function setInStream($inStream): void
    {
        $this->inStream = $inStream;
    }

    /**
     * @param resource $outStream
     *
     * @return void
     */
    public function setOutStream($outStream): void
    {
        $this->outStream = $outStream;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
