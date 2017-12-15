<?php


namespace SprykerMiddleware\Zed\Process\Business\Process\Hook;

interface PostProcessorHookInterface
{
    /**
     * @return void
     */
    public function process(): void;
}
