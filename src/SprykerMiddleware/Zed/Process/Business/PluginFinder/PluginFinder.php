<?php

namespace SprykerMiddleware\Zed\Process\Business\PluginFinder;

use SprykerMiddleware\Zed\Process\Business\Exception\IteratorNotConfiguredException;
use SprykerMiddleware\Zed\Process\Business\Exception\StagePluginsNotConfiguredException;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface;
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
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface[]
     */
    protected $iteratorPluginsStack;

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
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface[] $iteratorPluginsStack
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[] $preProcessorHookPluginsStack
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[] $postProcessorHookPluginsStack
     */
    public function __construct(
        ProcessConfig $config,
        array $stagePluginsStack,
        array $iteratorPluginsStack,
        array $preProcessorHookPluginsStack,
        array $postProcessorHookPluginsStack
    ) {
        $this->config = $config;
        $this->stagePluginsStack = $stagePluginsStack;
        $this->iteratorPluginsStack = $iteratorPluginsStack;
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
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface
     */
    public function getIteratorPluginByProcessName(string $processName): ProcessIteratorPluginInterface
    {
        $iteratorName = $this->getProcessIteratorPluginName($processName);

        return $this->iteratorPluginsStack[$iteratorName];
    }

    /**
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

        $iteratorPluginsStack = [];
        foreach ($this->iteratorPluginsStack as $iteratorPlugin) {
            $iteratorPluginsStack[$iteratorPlugin->getName()] = $iteratorPlugin;
        }
        $this->iteratorPluginsStack = $iteratorPluginsStack;

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
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\StagePluginsNotConfiguredException
     *
     * @return string[]
     */
    protected function getProcessStagePlugins(string $processName): array
    {
        $processConfiguration = $this->config->getProcessesConfig();
        if (isset($processConfiguration[$processName])) {
            return $processConfiguration[$processName];
        }

        throw new StagePluginsNotConfiguredException($processName);
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

    /**
     * @param string $processName
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\IteratorNotConfiguredException
     *
     * @return string
     */
    protected function getProcessIteratorPluginName(string $processName): string
    {
        $processIteratorConfig = $this->config->getProcessIteratorsConfig();
        if (isset($processIteratorConfig[$processName])) {
            return $processIteratorConfig[$processName];
        }

        throw new IteratorNotConfiguredException($processName);
    }
}
