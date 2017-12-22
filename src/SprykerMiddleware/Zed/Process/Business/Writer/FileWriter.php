<?php

namespace SprykerMiddleware\Zed\Process\Business\Writer;

use Generated\Shared\Transfer\WriterConfigTransfer;

class FileWriter implements WriterInterface
{
    /**
     * @var \Generated\Shared\Transfer\WriterConfigTransfer
     */
    protected $config;

    /**
     * @param \Generated\Shared\Transfer\WriterConfigTransfer $writerConfigTransfer
     */
    public function __construct(WriterConfigTransfer $writerConfigTransfer)
    {
        $writerConfigTransfer->requireDestination();
        $this->config = $writerConfigTransfer;
    }

    /**
     * @param mixed $payload
     *
     * @return array
     */
    public function write($payload)
    {
        file_put_contents($this->config->getDestination(), $payload);

        return $payload;
    }
}
