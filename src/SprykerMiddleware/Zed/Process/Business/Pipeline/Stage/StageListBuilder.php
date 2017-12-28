<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Psr\Log\LoggerInterface;
use SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface;

class StageListBuilder implements StageListBuilderInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface
     */
    protected $pluginFinder;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface $pluginFinder
     */
    public function __construct(PluginFinderInterface $pluginFinder)
    {
        $this->pluginFinder = $pluginFinder;
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param resource $inStream
     * @param resource $outStream
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[]
     */
    public function buildStageList(ProcessSettingsTransfer $processSettingsTransfer, $inStream, $outStream, LoggerInterface $logger): array
    {
        $stagePluginList = $this->pluginFinder->getStagePluginsByProcessName($processSettingsTransfer->getName());
        $stages = [];
        foreach ($stagePluginList as $stagePlugin) {
            $stagePlugin->setInStream($inStream);
            $stagePlugin->setOutStream($outStream);
            $stages[] = new Stage($stagePlugin, $logger);
        }
        return $stages;
    }
}
