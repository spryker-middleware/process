<?php

namespace SprykerMiddleware\Zed\Process\Business\Aggregator;

use Generated\Shared\Transfer\AggregatorSettingsTransfer;
use SprykerMiddleware\Zed\Process\Business\Renderer\RendererInterface;
use SprykerMiddleware\Zed\Process\Business\Writer\WriterInterface;

class BatchAggregator implements AggregatorInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Writer\WriterInterface
     */
    protected $writer;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Renderer\RendererInterface
     */
    protected $renderer;

    /**
     * @var \Generated\Shared\Transfer\AggregatorSettingsTransfer
     */
    protected $settings;

    /**
     * @var array
     */
    protected $storage = [];

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\Writer\WriterInterface $writer
     * @param \SprykerMiddleware\Zed\Process\Business\Renderer\RendererInterface $renderer
     * @param \Generated\Shared\Transfer\AggregatorSettingsTransfer $settings
     */
    public function __construct(WriterInterface $writer, RendererInterface $renderer, AggregatorSettingsTransfer $settings)
    {
        $this->writer = $writer;
        $this->renderer = $renderer;
        $this->settings = $settings;
    }

    /**
     * @param mixed $payload
     *
     * @return void
     */
    public function accept($payload)
    {
        $this->storage[] = $payload;

        if (count($this->storage) >= $this->settings->getThreshold()) {
            $this->flush();
        }
    }

    /**
     * @return void
     */
    public function flush()
    {
        $this->writer->write($this->renderer->render($this->storage));
        $this->storage = [];
    }
}
