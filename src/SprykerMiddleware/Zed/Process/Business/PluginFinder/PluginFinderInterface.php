<?php

namespace SprykerMiddleware\Zed\Process\Business\PluginFinder;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface;

interface PluginFinderInterface
{
    /**
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[]
     */
    public function getStagePluginsByProcessName(string $processName): array;

    /**
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface
     */
    public function getIteratorPluginByProcessName(string $processName): ProcessIteratorPluginInterface;

    /**
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[]
     */
    public function getPreProcessorHookPluginsByProcessName(string $processName): array;

    /**
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[]
     */
    public function getPostProcessorHookPluginsByProcessName(string $processName): array;
}
