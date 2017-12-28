<?php


namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook;

interface PreProcessorHookPluginInterface
{
    /**
     * @return void
     */
    public function process(): void;

    /**
     * @return string
     */
    public function getName(): string;
}
