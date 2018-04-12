<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\ProcessResult;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProcessConfigurationTransfer;
use Generated\Shared\Transfer\ProcessResultTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Generated\Shared\Transfer\StageResultsTransfer;
use SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot\ConfigurationSnapshotBuilder;
use SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelper;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator\NullIteratorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Log\MiddlewareLoggerConfigPlugin;
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

    protected const VALUE_INIT_RESULT = [
        0 => self::VALUE_PLUGIN_NAME,
        1 => 'StreamReaderStagePlugin',
        2 => 'StreamWriterStagePlugin',
    ];

    /**
     * @return void
     */
    public function testInitProcessResultTransfer(): void
    {
        $processResultHelper = $this->getProccessResultHelper();
        $processResultTransfer = $this->getProcessResultTransfer();
        $configurationBuilder = $this->getConfigurationSnapshotBuilder();
        $processSettingsTranfer = $this->getProcessSettingsTransfer();

        $processResultTransfer = $processResultHelper->initProcessResultTransfer($processResultTransfer, $this->getProcessConfigurationPluginMock(), $processSettingsTranfer);

        /** @var StageResultsTransfer $stageResult */
        foreach ($processResultTransfer->getStageResults() as $key => $stageResult) {
            $this->assertEquals($stageResult->getStageName(), self::VALUE_INIT_RESULT[$key]);
            $this->assertEquals($stageResult->getInputItemCount(), self::VALUE_INPUT_ITEM_COUNT);
            $this->assertEquals($stageResult->getOutputItemCount(), self::VALUE_OUTPUT_ITEM_COUNT);
        }
    }

    /**
     * @return void
     */
    public function testIncreaseProcessedItemCount(): void
    {
        $processResultHelper = $this->getProccessResultHelper();
        $processResultTransfer = $processResultHelper->increaseProcessedItemCount($this->getProcessResultTransfer());

        $this->assertEquals($processResultTransfer->getProcessedItemCount(),self::VALUE_PROCESSED_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseSkippedItemCount(): void
    {
        $processResultHelper = $this->getProccessResultHelper();
        $processResultTransfer = $processResultHelper->increaseSkippedItemCount($this->getProcessResultTransfer());

        $this->assertEquals($processResultTransfer->getSkippedItemCount(),self::VALUE_SKIPPED_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseItemCount(): void
    {
        $processResultHelper = $this->getProccessResultHelper();
        $processResultTransfer = $processResultHelper->increaseItemCount($this->getProcessResultTransfer());

        $this->assertEquals($processResultTransfer->getItemCount(),self::VALUE_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseFailedItemCount(): void
    {
        $processResultHelper = $this->getProccessResultHelper();
        $processResultTransfer = $processResultHelper->increaseFailedItemCount($this->getProcessResultTransfer());

        $this->assertEquals($processResultTransfer->getFailedItemCount(),self::VALUE_FAILED_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseStageInputItemCount(): void
    {
        $processResultHelper = $this->getProccessResultHelper();
        $processResultTransfer = $processResultHelper->increaseStageInputItemCount($this->getProcessResultTransfer(), self::VALUE_PLUGIN_NAME);

        $this->assertEquals($processResultTransfer->getStageResults()[0]->getInputItemCount(), self::VALUE_INPUT_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseStageOutputItemCount(): void
    {
        $processResultHelper = $this->getProccessResultHelper();
        $processResultTransfer = $processResultHelper->increaseStageOutputItemCount($this->getProcessResultTransfer(), self::VALUE_PLUGIN_NAME);

        $this->assertEquals($processResultTransfer->getStageResults()[0]->getOutputItemCount(), self::VALUE_OUTPUT_ITEM_COUNT + 1);
    }

    /**
     * @return void
     */
    public function testIncreaseStageItemExecutionTime(): void
    {
        $processResultHelper = $this->getProccessResultHelper();
        $processResultTransfer = $processResultHelper->increaseStageItemExecutionTime(
            $this->getProcessResultTransfer(),
            self::VALUE_PLUGIN_NAME,
            self::VALUE_ADDITIONAL_EXECUTION_TIME
        );

        $this->assertEquals(
            $processResultTransfer->getStageResults()[0]->getTotalExecutionTime(),
            self::VALUE_EXECUTION_TIME + self::VALUE_ADDITIONAL_EXECUTION_TIME
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
        $processResultTransfer->setItemCount(self::VALUE_ITEM_COUNT);
        $processResultTransfer->setSkippedItemCount(self::VALUE_SKIPPED_ITEM_COUNT);
        $processResultTransfer->setProcessedItemCount(self::VALUE_PROCESSED_ITEM_COUNT);
        $processResultTransfer->setFailedItemCount(self::VALUE_FAILED_ITEM_COUNT);
        $processResultTransfer->setEndTime(time());
        $processResultTransfer->setProcessConfiguration(new ProcessConfigurationTransfer());
        $processResultTransfer->setStageResults($this->getStageResults());

        return $processResultTransfer;
    }

    /**
     * @return ConfigurationSnapshotBuilder
     */
    protected function getConfigurationSnapshotBuilder(): ConfigurationSnapshotBuilder
    {
        return new ConfigurationSnapshotBuilder();
    }

    /**
     * @return ProcessResultHelper
     */
    protected function getProccessResultHelper(): ProcessResultHelper
    {
        return new ProcessResultHelper($this->getConfigurationSnapshotBuilder());
    }

    /**
     * @return \ArrayObject
     */
    protected function getStageResults(): \ArrayObject
    {
        $object = new \ArrayObject();
        $object->append($this->getStageResultsTransfer());

        return $object;
    }

    /**
     * @return StageResultsTransfer
     */
    protected function  getStageResultsTransfer(): StageResultsTransfer
    {
        $stageResultsTransfer = new StageResultsTransfer();
        $stageResultsTransfer->setStageName(self::VALUE_PLUGIN_NAME);
        $stageResultsTransfer->setInputItemCount(self::VALUE_INPUT_ITEM_COUNT);
        $stageResultsTransfer->setOutputItemCount(self::VALUE_OUTPUT_ITEM_COUNT);
        $stageResultsTransfer->setTotalExecutionTime(self::VALUE_EXECUTION_TIME);

        return $stageResultsTransfer;
    }

    /**
     * @return ProcessSettingsTransfer
     */
    protected function getProcessSettingsTransfer(): ProcessSettingsTransfer
    {
        $processSettingTransfer = new ProcessSettingsTransfer();

        return $processSettingTransfer;
    }

    /**
     * @return ProcessConfigurationPluginInterface
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
