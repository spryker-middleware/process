<?php


namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Hook;

interface PostProcessorHookPluginInterface
{
    /**
     * @return void
     */
    public function process(): void;
}
