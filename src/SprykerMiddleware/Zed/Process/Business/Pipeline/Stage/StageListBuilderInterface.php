<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use Psr\Log\LoggerInterface;

interface StageListBuilderInterface
{
    /**
     * @param \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface[] $stagePluginList
     * @param resource $inStream
     * @param resource $outStream
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[]
     */
    public function buildStageList(array $stagePluginList, $inStream, $outStream, LoggerInterface $logger): array;
}
