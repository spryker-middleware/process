<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\ProcessResult;

use Generated\Shared\Transfer\ProcessResultTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;

interface ProcessResultHelperInterface
{
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
    ): ProcessResultTransfer;

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseProcessedItemCount(ProcessResultTransfer $processResultTransfer);

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseSkippedItemCount(ProcessResultTransfer $processResultTransfer);

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseFailedItemCount(ProcessResultTransfer $processResultTransfer);

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseItemCount(ProcessResultTransfer $processResultTransfer);

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     * @param string $stagePluginName
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseStageInputItemCount(ProcessResultTransfer $processResultTransfer, string $stagePluginName);

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     * @param string $stagePluginName
     *
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    public function increaseStageOutputItemCount(ProcessResultTransfer $processResultTransfer, string $stagePluginName);
}
