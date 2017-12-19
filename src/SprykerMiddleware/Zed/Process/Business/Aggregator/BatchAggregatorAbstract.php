<?php

namespace SprykerMiddleware\Zed\Process\Business\Aggregator;

use Generated\Shared\Transfer\AggregatorSettingsTransfer;

abstract class BatchAggregatorAbstract implements AggregatorInterface
{
    /**
     * @var \Generated\Shared\Transfer\AggregatorSettingsTransfer|\Generated\Shared\Transfer\IteratorSettingsTransfer|null
     */
    protected $settings;

    /**
     * @var array
     */
    protected $storage = [];

    /**
     * @param \Generated\Shared\Transfer\AggregatorSettingsTransfer|null $settings
     */
    public function __construct(AggregatorSettingsTransfer $settings = null)
    {
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

        if ($this->settings->getThreshold() >= count($this->storage)) {
            $this->flush();
        }
    }

    /**
     * @return void
     */
    abstract public function flush();
}
