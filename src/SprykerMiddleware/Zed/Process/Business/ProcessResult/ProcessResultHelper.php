<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\ProcessResult;

use Generated\Shared\Transfer\ProcessResultTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Generated\Shared\Transfer\StageResultsTransfer;
use SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot\ConfigurationSnapshotBuilderInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;

class ProcessResultHelper implements ProcessResultHelperInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot\ConfigurationSnapshotBuilderInterface
     */
    private $configurationSnapshotBuilder;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot\ConfigurationSnapshotBuilderInterface $configurationSnapshotBuilder
     */
    public function __construct(ConfigurationSnapshotBuilderInterface $configurationSnapshotBuilder)
    {
        $this->configurationSnapshotBuilder = $configurationSnapshotBuilder;
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface $processConfigurationPlugin
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function initProcessResultTransfer(
        ProcessResultTransfer $processResultTransfer,
        ProcessConfigurationPluginInterface $processConfigurationPlugin,
        ProcessSettingsTransfer $processSettingsTransfer
    ): ProcessResultTransfer {
        $processResultTransfer->setStartTime(time());
        $processResultTransfer->setProcessName($processSettingsTransfer->getName());
        $processResultTransfer->setItemCount(0);
        $processResultTransfer->setSkippedItemCount(0);
        $processResultTransfer->setProcessedItemCount(0);
        $processResultTransfer->setFailedItemCount(0);

        $processConfigurationTransfer = $this->configurationSnapshotBuilder
            ->build($processConfigurationPlugin, $processSettingsTransfer);
        $processResultTransfer
            ->setProcessConfiguration($processConfigurationTransfer);

        foreach ($processResultTransfer->getProcessConfiguration()->getStagePluginNames() as $stagePluginName) {
            $stageResultTransfer = new StageResultsTransfer();
            $stageResultTransfer->setStageName($stagePluginName)
                ->setInputItemCount(0)
                ->setOutputItemCount(0)
                ->setTotalExecutionTime(0);
            $processResultTransfer->addStageResult($stageResultTransfer);
        }

        return $processResultTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseProcessedItemCount(ProcessResultTransfer $processResultTransfer)
    {
        $count = $processResultTransfer->getProcessedItemCount();
        $processResultTransfer->setProcessedItemCount(++$count);

        return $processResultTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseSkippedItemCount(ProcessResultTransfer $processResultTransfer)
    {
        $count = $processResultTransfer->getSkippedItemCount();
        $processResultTransfer->setSkippedItemCount(++$count);

        return $processResultTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseItemCount(ProcessResultTransfer $processResultTransfer)
    {
        $count = $processResultTransfer->getItemCount();
        $processResultTransfer->setItemCount(++$count);

        return $processResultTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseFailedItemCount(ProcessResultTransfer $processResultTransfer)
    {
        $count = $processResultTransfer->getFailedItemCount();
        $processResultTransfer->setFailedItemCount(++$count);

        return $processResultTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     * @param string $stagePluginName
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseStageInputItemCount(ProcessResultTransfer $processResultTransfer, string $stagePluginName)
    {
        foreach ($processResultTransfer->getStageResults() as $stageResult) {
            if ($stageResult->getStageName() === $stagePluginName) {
                $count = $stageResult->getInputItemCount();
                $stageResult->setInputItemCount(++$count);

                return $processResultTransfer;
            }
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     * @param string $stagePluginName
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseStageOutputItemCount(ProcessResultTransfer $processResultTransfer, string $stagePluginName)
    {
        foreach ($processResultTransfer->getStageResults() as $stageResult) {
            if ($stageResult->getStageName() === $stagePluginName) {
                $count = $stageResult->getOutputItemCount();
                $stageResult->setOutputItemCount(++$count);

                return $processResultTransfer;
            }
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     * @param string $stagePluginName
     * @param int $time
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseStageItemExecutionTime(ProcessResultTransfer $processResultTransfer, string $stagePluginName, int $time)
    {
        foreach ($processResultTransfer->getStageResults() as $stageResult) {
            if ($stageResult->getStageName() === $stagePluginName) {
                $totalTime = $stageResult->getTotalExecutionTime();
                $stageResult->setTotalExecutionTime($totalTime + $time);

                return $processResultTransfer;
            }
        }
    }
}
