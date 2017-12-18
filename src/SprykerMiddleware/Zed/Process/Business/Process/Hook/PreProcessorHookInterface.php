<?php


namespace SprykerMiddleware\Zed\Process\Business\Process\Hook;

interface PreProcessorHookInterface
{
    /**
     * @return void
     */
    public function process(): void;
}
