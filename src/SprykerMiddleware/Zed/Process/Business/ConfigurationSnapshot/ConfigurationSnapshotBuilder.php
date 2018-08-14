<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
        $processConfigurationTransfer = (new ProcessConfigurationTransfer())
            ->setIteratorPluginName($processConfigurationPlugin->getIteratorPlugin()->getName())
            ->setLoggerPluginName($processConfigurationPlugin->getLoggerPlugin()->getName());

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
        $inputStreamPluginTransfer = (new StreamConfigurationTransfer())
            ->setStreamPluginName($processConfigurationPlugin->getInputStreamPlugin()->getName())
            ->setPath($processSettingsTransfer->getInputPath());

        $processConfigurationTransfer->setInputStreamPlugin($inputStreamPluginTransfer);

        $outputStreamPluginTransfer = (new StreamConfigurationTransfer())
            ->setStreamPluginName($processConfigurationPlugin->getOutputStreamPlugin()->getName())
            ->setPath($processSettingsTransfer->getOutputPath());
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
            $processConfigurationTransfer->addStagePluginName($stagePlugin->getName());
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
            $processConfigurationTransfer->addPreProcessHookPluginName($preHookPlugin->getName());
        }

        foreach ($processConfigurationPlugin->getPostProcessorHookPlugins() as $postHookPlugin) {
            $processConfigurationTransfer->addPostProcessHookPluginName($postHookPlugin->getName());
        }

        return $processConfigurationTransfer;
    }
}
