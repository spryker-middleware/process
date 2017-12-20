<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use Psr\Log\LoggerInterface;

interface StageListBuilderInterface
{
    /**
     * @param \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface[] $stagePluginList
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\Stage[]
     */
    public function buildStageList(array $stagePluginList, LoggerInterface $logger): array;
}
