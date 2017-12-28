<?php

namespace SprykerMiddleware\Zed\Process\Business\PluginFinder;

use SprykerMiddleware\Zed\Process\Business\Exception\StagePluginsForProcessNotConfiguredException;
use SprykerMiddleware\Zed\Process\ProcessConfig;

class PluginFinder implements PluginFinderInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\ProcessConfig
     */
    protected $config;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[]
     */
    protected $stagePluginsStack;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[]
     */
    protected $preProcessorHookPluginsStack;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[]
     */
    protected $postProcessorHookPluginsStack;

    /**
     * @param \SprykerMiddleware\Zed\Process\ProcessConfig $config
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[] $stagePluginsStack
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[] $preProcessorHookPluginsStack
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[] $postProcessorHookPluginsStack
     */
    public function __construct(
        ProcessConfig $config,
        array $stagePluginsStack,
        array $preProcessorHookPluginsStack,
        array $postProcessorHookPluginsStack
    ) {
        $this->config = $config;
        $this->stagePluginsStack = $stagePluginsStack;
        $this->preProcessorHookPluginsStack = $preProcessorHookPluginsStack;
        $this->postProcessorHookPluginsStack = $postProcessorHookPluginsStack;
        $this->init();
    }

    /**
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[]
     */
    public function getStagePluginsByProcessName(string $processName): array
    {
        return $this->filterPlugins($this->stagePluginsStack, $this->getProcessStagePlugins($processName));
    }

    /**
    /**
     *
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[]
     */
    public function getPreProcessorHookPluginsByProcessName(string $processName): array
    {
        return $this->filterPlugins($this->preProcessorHookPluginsStack, $this->getPreProcessorHooksPlugins($processName));
    }

    /**
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[]
     */
    public function getPostProcessorHookPluginsByProcessName(string $processName): array
    {
        return $this->filterPlugins($this->postProcessorHookPluginsStack, $this->getPostProcessorHooksPlugins($processName));
    }

    /**
     * @return void
     */
    protected function init()
    {
        $stagePluginsStack = [];
        foreach ($this->stagePluginsStack as $stagePlugin) {
            $stagePluginsStack[$stagePlugin->getName()] = $stagePlugin;
        }
        $this->stagePluginsStack = $stagePluginsStack;

        $preProcessorHookPluginsStack = [];
        foreach ($this->preProcessorHookPluginsStack as $preProcessorHookPlugin) {
            $preProcessorHookPluginsStack[$preProcessorHookPlugin->getName()] = $preProcessorHookPlugin;
        }
        $this->preProcessorHookPluginsStack = $preProcessorHookPluginsStack;

        $postProcessorHookPluginsStack = [];
        foreach ($this->postProcessorHookPluginsStack as $postProcessorHookPlugin) {
            $postProcessorHookPluginsStack[$postProcessorHookPlugin->getName()] = $postProcessorHookPlugin;
        }
        $this->postProcessorHookPluginsStack = $postProcessorHookPluginsStack;
    }

    /**
     * @param string $processName
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\StagePluginsForProcessNotConfiguredException
     *
     * @return string[]
     */
    protected function getProcessStagePlugins(string $processName): array
    {
        $processConfiguration = $this->config->getProcessesConfig();
        if (isset($processConfiguration[$processName])) {
            return $processConfiguration[$processName];
        }

        throw new StagePluginsForProcessNotConfiguredException($processName);
    }

    /**
     * @param string $processName
     *
     * @return string[]
     */
    protected function getPreProcessorHooksPlugins(string $processName): array
    {
        $preProcessorHooksConfig = $this->config->getPreProcessorHooksConfig();
        if (isset($preProcessorHooksConfig[$processName])) {
            return $preProcessorHooksConfig[$processName];
        }

        return [];
    }

    /**
     * @param string $processName
     *
     * @return string[]
     */
    protected function getPostProcessorHooksPlugins($processName)
    {
        $postProcessorHooksConfig = $this->config->getPostProcessorHooksConfig();
        if (isset($postProcessorHooksConfig[$processName])) {
            return $postProcessorHooksConfig[$processName];
        }

        return [];
    }

    /**
     * @param array $pluginStack
     * @param array $enabledPlugins
     *
     * @return array
     */
    protected function filterPlugins(array $pluginStack, array $enabledPlugins): array
    {
        $filteredPlugins = [];
        foreach ($enabledPlugins as $pluginName) {
            $filteredPlugins[$pluginName] = $pluginStack[$pluginName];
        }

        return $filteredPlugins;
    }
}
