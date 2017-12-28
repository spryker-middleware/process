<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface;

abstract class AbstractPostProcessorHookPlugin extends AbstractPlugin implements PostProcessorHookPluginInterface
{
    const PLUGIN_NAME = 'SPRYKER_MIDDLEWARE_ABSTRACT_POST_PROCESSOR_HOOK_PLUGIN';

    /**
     * @return void
     */
    abstract public function process(): void;

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
