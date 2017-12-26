<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use Psr\Log\LoggerInterface;

class StageListBuilder implements StageListBuilderInterface
{
    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[] $stagePluginList
     * @param resource $inStream
     * @param resource $outStream
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\Stage[]
     */
    public function buildStageList(array $stagePluginList, $inStream, $outStream, LoggerInterface $logger): array
    {
        $stages = [];
        foreach ($stagePluginList as $stagePlugin) {
            $stagePlugin->setInStream($inStream);
            $stagePlugin->setOutStream($outStream);
            $stages[] = new Stage($stagePlugin, $logger);
        }
        return $stages;
    }
}
