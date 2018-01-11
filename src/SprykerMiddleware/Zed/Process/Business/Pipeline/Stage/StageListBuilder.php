<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use Generated\Shared\Transfer\ProcessSettingsTransfer;
use SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface;

class StageListBuilder implements StageListBuilderInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface
     */
    protected $pluginResolver;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface $pluginResolver
     */
    public function __construct(ProcessPluginResolverInterface $pluginResolver)
    {
        $this->pluginResolver = $pluginResolver;
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[]
     */
    public function buildStageList(ProcessSettingsTransfer $processSettingsTransfer): array
    {
        $stagePluginList = $this->pluginResolver
            ->getProcessConfigurationPluginByProcessName($processSettingsTransfer->getName())
            ->getStagePlugins();

        $stages = [];
        foreach ($stagePluginList as $stagePlugin) {
            $stages[] = new Stage($stagePlugin);
        }
        return $stages;
    }
}
