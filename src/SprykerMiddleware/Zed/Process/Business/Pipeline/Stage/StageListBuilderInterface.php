<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Psr\Log\LoggerInterface;

interface StageListBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param resource $inStream
     * @param resource $outStream
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[]
     */
    public function buildStageList(ProcessSettingsTransfer $processSettingsTransfer, $inStream, $outStream, LoggerInterface $logger): array;
}
