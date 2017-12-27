<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Psr\Log\LoggerInterface;

class StageListBuilder implements StageListBuilderInterface
{
    const PIPELINE = 'PIPELINE';
    /**
     * @var array
     */
    protected $processes;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[][]
     */
    protected $pipelines;

    /**
     * @param array $processes
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[][] $pipelines
     */
    public function __construct(array $processes, array $pipelines)
    {
        $this->processes = $processes;
        $this->pipelines = $pipelines;
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
        $stagePluginList = $this->getStagePluginsListForProcess($processSettingsTransfer->getName());
        $stages = [];
        foreach ($stagePluginList as $stagePlugin) {
            $stagePlugin->setInStream($inStream);
            $stagePlugin->setOutStream($outStream);
            $stages[] = new Stage($stagePlugin, $logger);
        }
        return $stages;
    }

    /**
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[]
     */
    protected function getStagePluginsListForProcess($processName)
    {
        $pipelineName = $this->processes[$processName][static::PIPELINE];
        return $this->getPipelineStagePluginsList($pipelineName);
    }

    /**
     * @param string $pipelineName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[]
     */
    protected function getPipelineStagePluginsList($pipelineName)
    {
        return $this->pipelines[$pipelineName];
    }
}
