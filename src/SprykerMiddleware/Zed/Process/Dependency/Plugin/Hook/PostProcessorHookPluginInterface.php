<?php


namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook;

interface PostProcessorHookPluginInterface
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
