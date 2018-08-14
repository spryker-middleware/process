<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\ConfigurationSnapshot;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProcessConfigurationTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Generated\Shared\Transfer\StreamConfigurationTransfer;
use SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot\ConfigurationSnapshotBuilder;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator\NullIteratorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Log\MiddlewareLoggerConfigPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonInputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonOutputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamWriterStagePlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;

/**
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group ConfigurationSnapshotBuilder
 * @group ConfigurationSnapshotBuilderTest
 */
class ConfigurationSnapshotBuilderTest extends Unit
{
    /**
     * @return void
     */
    public function testBuild(): void
    {
        $builder = new ConfigurationSnapshotBuilder();
        $expectedTransfer = $this->getExpectedProcessConfigurationTransfer();

        $processConfigurationTransfer = $builder->build($this->getProcessConfigurationPluginMock(), new ProcessSettingsTransfer());

        $this->assertEquals($expectedTransfer->getIteratorPluginName(), $processConfigurationTransfer->getIteratorPluginName());
        $this->assertEquals($expectedTransfer->getLoggerPluginName(), $processConfigurationTransfer->getLoggerPluginName());
        $this->assertEquals($expectedTransfer->getInputStreamPlugin()->getStreamPluginName(), $processConfigurationTransfer->getInputStreamPlugin()->getStreamPluginName());
        $this->assertEquals($expectedTransfer->getOutputStreamPlugin()->getStreamPluginName(), $processConfigurationTransfer->getOutputStreamPlugin()->getStreamPluginName());
        $this->assertEquals($expectedTransfer->getStagePluginNames()[0], 'StreamWriterStagePlugin');
        $this->assertEquals($expectedTransfer->getPreProcessHookPluginNames(), null);
        $this->assertEquals($expectedTransfer->getPostProcessHookPluginNames()[0], 'ReportPostProcessorHookPlugin');
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

        $mock->method('getStagePlugins')->willReturn([new StreamWriterStagePlugin()]);
        $mock->method('getIteratorPlugin')->willReturn(new NullIteratorPlugin());
        $mock->method('getLoggerPlugin')->willReturn(new MiddlewareLoggerConfigPlugin());
        $mock->method('getInputStreamPlugin')->willReturn(new JsonInputStreamPlugin());
        $mock->method('getOutputStreamPlugin')->willReturn(new JsonOutputStreamPlugin());
        $mock->method('getPostProcessorHookPlugins')->willReturn([]);
        $mock->method('getPreProcessorHookPlugins')->willReturn([]);

        return $mock;
    }

    /**
     * @return \Generated\Shared\Transfer\ProcessConfigurationTransfer
     */
    protected function getExpectedProcessConfigurationTransfer(): ProcessConfigurationTransfer
    {
        $transfer = new ProcessConfigurationTransfer();
        $transfer->setLoggerPluginName('MiddlewareLoggerConfigPlugin');
        $transfer->setIteratorPluginName('NullIteratorPlugin');
        $transfer->setInputStreamPlugin((new StreamConfigurationTransfer())->setStreamPluginName('JsonInputStreamPlugin'));
        $transfer->setOutputStreamPlugin((new StreamConfigurationTransfer())->setStreamPluginName('JsonOutputStreamPlugin'));
        $transfer->addStagePluginName('StreamWriterStagePlugin');
        $transfer->addPostProcessHookPluginName('ReportPostProcessorHookPlugin');

        return $transfer;
    }
}
