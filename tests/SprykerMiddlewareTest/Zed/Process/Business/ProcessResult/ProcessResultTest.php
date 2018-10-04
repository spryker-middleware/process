<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\ProcessResult;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProcessConfigurationTransfer;
use Generated\Shared\Transfer\ProcessResultTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Generated\Shared\Transfer\StageResultsTransfer;
use SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot\ConfigurationSnapshotBuilder;
use SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot\ConfigurationSnapshotBuilderInterface;
use SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelper;
use SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelperInterface;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamReaderStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamWriterStagePlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;

/**
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group ProcessResultHelper
 * @group ProcessResultHelperTest
 */
class ProcessResultTest extends Unit
{
    protected const VALUE_ITEM_COUNT = 1;

    protected const VALUE_SKIPPED_ITEM_COUNT = 1;

    protected const VALUE_PROCESSED_ITEM_COUNT = 1;

    protected const VALUE_FAILED_ITEM_COUNT = 1;

    protected const VALUE_PROCESS_NAME = 'Process name';

    protected const VALUE_PLUGIN_NAME = 'Stage name';

    protected const VALUE_INPUT_ITEM_COUNT = 0;

    protected const VALUE_OUTPUT_ITEM_COUNT = 0;

    protected const VALUE_EXECUTION_TIME = 1000;

    protected const VALUE_ADDITIONAL_EXECUTION_TIME = 1000;

    protected const VALUE_INIT_RESULT_NAMES = [
        0 => self::VALUE_PLUGIN_NAME,
        1 => 'StreamReaderStagePlugin',
        2 => 'StreamWriterStagePlugin',
    ];

    /**
     * @return void
     */
    public function testInitProcessResultTransfer(): void
    {
        $processResultHelper = $this->getProcessResultHelper();
        $processResultTransfer = $this->getProcessResultTransfer();
        $processSettingsTransfer = $this->getProcessSettingsTransfer();

        $processResultTransfer = $processResultHelper->initProcessResultTransfer($processResultTransfer, $this->getProcessConfigurationPluginMock(), $processSettingsTransfer);

        /** @var \Generated\Shared\Transfer\StageResultsTransfer $stageResult */
        foreach ($processResultTransfer->getStageResults() as $key => $stageResult) {
            $this->assertEquals($stageResult->getStageName(), static::VALUE_INIT_RESULT_NAMES[$key]);
            $this->assertEquals($stageResult->getInputItemCount(), static::VALUE_INPUT_ITEM_COUNT);
            $this->assertEquals($stageResult->getOutputItemCount(), static::VALUE_OUTPUT_ITEM_COUNT);
        }
    }

    /**
     * @return void
     */
    public function testIncreaseProcessedItemCount(): void
    {
        $processResultHelper = $this->getProcessResultHelper();
        $processResultTransfer = $processResultHelper->increaseProcessedItemCount($this->getProcessResultTransfer());

        $this->assertEquals($processResultTransfer->getProcessedItemCount(), static::VALUE_PROCESSED_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseSkippedItemCount(): void
    {
        $processResultHelper = $this->getProcessResultHelper();
        $processResultTransfer = $processResultHelper->increaseSkippedItemCount($this->getProcessResultTransfer());

        $this->assertEquals($processResultTransfer->getSkippedItemCount(), static::VALUE_SKIPPED_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseItemCount(): void
    {
        $processResultHelper = $this->getProcessResultHelper();
        $processResultTransfer = $processResultHelper->increaseItemCount($this->getProcessResultTransfer());

        $this->assertEquals($processResultTransfer->getItemCount(), static::VALUE_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseFailedItemCount(): void
    {
        $processResultHelper = $this->getProcessResultHelper();
        $processResultTransfer = $processResultHelper->increaseFailedItemCount($this->getProcessResultTransfer());

        $this->assertEquals($processResultTransfer->getFailedItemCount(), static::VALUE_FAILED_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseStageInputItemCount(): void
    {
        $processResultHelper = $this->getProcessResultHelper();
        $processResultTransfer = $processResultHelper->increaseStageInputItemCount($this->getProcessResultTransfer(), static::VALUE_PLUGIN_NAME);

        $this->assertEquals($processResultTransfer->getStageResults()[0]->getInputItemCount(), static::VALUE_INPUT_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseStageOutputItemCount(): void
    {
        $processResultHelper = $this->getProcessResultHelper();
        $processResultTransfer = $processResultHelper->increaseStageOutputItemCount($this->getProcessResultTransfer(), static::VALUE_PLUGIN_NAME);

        $this->assertEquals($processResultTransfer->getStageResults()[0]->getOutputItemCount(), static::VALUE_OUTPUT_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseStageItemExecutionTime(): void
    {
        $processResultHelper = $this->getProcessResultHelper();
        $processResultTransfer = $processResultHelper->increaseStageItemExecutionTime(
            $this->getProcessResultTransfer(),
            static::VALUE_PLUGIN_NAME,
            static::VALUE_ADDITIONAL_EXECUTION_TIME
        );

        $this->assertEquals(
            $processResultTransfer->getStageResults()[0]->getTotalExecutionTime(),
            static::VALUE_EXECUTION_TIME + static::VALUE_ADDITIONAL_EXECUTION_TIME
        );
    }

    /**
     * @return \Generated\Shared\Transfer\ProcessResultTransfer
     */
    protected function getProcessResultTransfer(): ProcessResultTransfer
    {
        $processResultTransfer = new ProcessResultTransfer();
        $processResultTransfer->setStartTime(time());
        $processResultTransfer->setProcessName('Process name');
        $processResultTransfer->setItemCount(static::VALUE_ITEM_COUNT);
        $processResultTransfer->setSkippedItemCount(static::VALUE_SKIPPED_ITEM_COUNT);
        $processResultTransfer->setProcessedItemCount(static::VALUE_PROCESSED_ITEM_COUNT);
        $processResultTransfer->setFailedItemCount(static::VALUE_FAILED_ITEM_COUNT);
        $processResultTransfer->setEndTime(time());
        $processResultTransfer->setProcessConfiguration(new ProcessConfigurationTransfer());
        $processResultTransfer->setStageResults($this->getStageResults());

        return $processResultTransfer;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot\ConfigurationSnapshotBuilderInterface
     */
    protected function getConfigurationSnapshotBuilder(): ConfigurationSnapshotBuilderInterface
    {
        return new ConfigurationSnapshotBuilder();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelperInterface
     */
    protected function getProcessResultHelper(): ProcessResultHelperInterface
    {
        return new ProcessResultHelper($this->getConfigurationSnapshotBuilder());
    }

    /**
     * @return \ArrayObject
     */
    protected function getStageResults(): ArrayObject
    {
        $object = new ArrayObject();
        $object->append($this->getStageResultsTransfer());

        return $object;
    }

    /**
     * @return \Generated\Shared\Transfer\StageResultsTransfer
     */
    protected function getStageResultsTransfer(): StageResultsTransfer
    {
        $stageResultsTransfer = new StageResultsTransfer();
        $stageResultsTransfer->setStageName(static::VALUE_PLUGIN_NAME);
        $stageResultsTransfer->setInputItemCount(static::VALUE_INPUT_ITEM_COUNT);
        $stageResultsTransfer->setOutputItemCount(static::VALUE_OUTPUT_ITEM_COUNT);
        $stageResultsTransfer->setTotalExecutionTime(static::VALUE_EXECUTION_TIME);

        return $stageResultsTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\ProcessSettingsTransfer
     */
    protected function getProcessSettingsTransfer(): ProcessSettingsTransfer
    {
        $processSettingTransfer = new ProcessSettingsTransfer();

        return $processSettingTransfer;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface
     */
    protected function getProcessConfigurationPluginMock(): ProcessConfigurationPluginInterface
    {
        $mock = $this->getMockBuilder(ProcessConfigurationPluginInterface::class)
            ->setMethods([
                'getProcessName',
                'getInputStreamPlugin',
                'getOutputStreamPlugin',
                'getIteratorPlugin',
                'getStagePlugins',
                'getLoggerPlugin',
                'getPreProcessorHookPlugins',
                'getPostProcessorHookPlugins',
            ])
            ->disableProxyingToOriginalMethods()
            ->disableOriginalClone()
            ->getMock();

        $mock->method('getStagePlugins')->willReturn([new StreamReaderStagePlugin(), new StreamWriterStagePlugin()]);

        return $mock;
    }
}
