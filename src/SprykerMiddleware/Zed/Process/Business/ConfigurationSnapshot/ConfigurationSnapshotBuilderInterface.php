<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot;

use Generated\Shared\Transfer\ProcessConfigurationTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;

interface ConfigurationSnapshotBuilderInterface
{
    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface $processConfigurationPlugin
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\ProcessConfigurationTransfer
     */
    public function build(
        ProcessConfigurationPluginInterface $processConfigurationPlugin,
        ProcessSettingsTransfer $processSettingsTransfer
    ): ProcessConfigurationTransfer;
}
