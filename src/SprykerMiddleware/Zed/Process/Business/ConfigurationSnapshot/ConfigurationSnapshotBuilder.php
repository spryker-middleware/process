<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot;

use Generated\Shared\Transfer\ProcessConfigurationTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Generated\Shared\Transfer\StreamConfigurationTransfer;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;

class ConfigurationSnapshotBuilder implements ConfigurationSnapshotBuilderInterface
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
    ): ProcessConfigurationTransfer {
        $processConfigurationTransfer = new ProcessConfigurationTransfer();
        $processConfigurationTransfer->setIteratorPluginName(get_class($processConfigurationPlugin->getIteratorPlugin()));
        $processConfigurationTransfer->setLoggerPluginName(get_class($processConfigurationPlugin->getLoggerPlugin()));
        $this->buildStreamConfigurationSnapshot($processConfigurationTransfer, $processConfigurationPlugin, $processSettingsTransfer);
        $this->buildStagesConfigurationSnapshot($processConfigurationTransfer, $processConfigurationPlugin);
        $this->buildHooksConfigurationSnapshot($processConfigurationTransfer, $processConfigurationPlugin);

        return $processConfigurationTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessConfigurationTransfer $processConfigurationTransfer
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface $processConfigurationPlugin
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\ProcessConfigurationTransfer
     */
    protected function buildStreamConfigurationSnapshot(
        ProcessConfigurationTransfer $processConfigurationTransfer,
        ProcessConfigurationPluginInterface $processConfigurationPlugin,
        ProcessSettingsTransfer $processSettingsTransfer
    ): ProcessConfigurationTransfer {
        $inputStreamPluginTransfer = new StreamConfigurationTransfer();
        $inputStreamPluginTransfer->setStreamPluginName(get_class($processConfigurationPlugin->getInputStreamPlugin()));
        $inputStreamPluginTransfer->setPath($processSettingsTransfer->getInputPath());
        $processConfigurationTransfer->setInputStreamPlugin($inputStreamPluginTransfer);

        $outputStreamPluginTransfer = new StreamConfigurationTransfer();
        $outputStreamPluginTransfer->setStreamPluginName(get_class($processConfigurationPlugin->getOutputStreamPlugin()));
        $outputStreamPluginTransfer->setPath($processSettingsTransfer->getOutputPath());
        $processConfigurationTransfer->setOutputStreamPlugin($outputStreamPluginTransfer);

        return $processConfigurationTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessConfigurationTransfer $processConfigurationTransfer
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface $processConfigurationPlugin
     *
     * @return \Generated\Shared\Transfer\ProcessConfigurationTransfer
     */
    protected function buildStagesConfigurationSnapshot(
        ProcessConfigurationTransfer $processConfigurationTransfer,
        ProcessConfigurationPluginInterface $processConfigurationPlugin
    ): ProcessConfigurationTransfer {
        foreach ($processConfigurationPlugin->getStagePlugins() as $stagePlugin) {
            $processConfigurationTransfer->addStagePluginName(get_class($stagePlugin));
        }

        return $processConfigurationTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessConfigurationTransfer $processConfigurationTransfer
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface $processConfigurationPlugin
     *
     * @return \Generated\Shared\Transfer\ProcessConfigurationTransfer
     */
    private function buildHooksConfigurationSnapshot(
        ProcessConfigurationTransfer $processConfigurationTransfer,
        ProcessConfigurationPluginInterface $processConfigurationPlugin
    ): ProcessConfigurationTransfer {
        foreach ($processConfigurationPlugin->getPreProcessorHookPlugins() as $preHookPlugin) {
            $processConfigurationTransfer->addPreProcessHookPluginName(get_class($preHookPlugin));
        }

        foreach ($processConfigurationPlugin->getPostProcessorHookPlugins() as $postHookPlugin) {
            $processConfigurationTransfer->addPostProcessHookPluginName(get_class($postHookPlugin));
        }

        return $processConfigurationTransfer;
    }
}
