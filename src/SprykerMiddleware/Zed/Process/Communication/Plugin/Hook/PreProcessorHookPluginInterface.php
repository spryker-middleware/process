<?php


namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Hook;

interface PreProcessorHookPluginInterface
{
    /**
     * @return void
     */
    public function process(): void;
}
