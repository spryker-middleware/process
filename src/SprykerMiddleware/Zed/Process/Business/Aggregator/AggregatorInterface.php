<?php

namespace SprykerMiddleware\Zed\Process\Business\Aggregator;

interface AggregatorInterface
{
    /**
     * @param mixed $payload
     *
     * @return void
     */
    public function accept($payload);

    /**
     * @return void
     */
    public function flush();
}
