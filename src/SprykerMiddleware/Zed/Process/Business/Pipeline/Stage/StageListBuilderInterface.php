<?php

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use Generated\Shared\Transfer\ProcessSettingsTransfer;

interface StageListBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[]
     */
    public function buildStageList(ProcessSettingsTransfer $processSettingsTransfer): array;
}
