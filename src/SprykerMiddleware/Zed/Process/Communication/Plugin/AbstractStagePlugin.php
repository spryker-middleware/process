<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

abstract class AbstractStagePlugin extends AbstractPlugin implements StagePluginInterface
{
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
     *
     * @return mixed
     */
    abstract public function process($payload);

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
}
