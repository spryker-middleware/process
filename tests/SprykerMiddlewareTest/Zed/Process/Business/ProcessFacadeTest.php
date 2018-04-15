<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\IteratorConfigTransfer;
use Generated\Shared\Transfer\LoggerConfigTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Spryker\Zed\Kernel\Container;
use SprykerMiddleware\Zed\Process\Business\ProcessBusinessFactory;
use SprykerMiddleware\Zed\Process\Business\ProcessFacade;
use SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator\NullIteratorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Log\MiddlewareLoggerConfigPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonInputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonOutputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamReaderStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamWriterStagePlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;
use SprykerMiddleware\Zed\Process\ProcessDependencyProvider;

/**
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group ProcessFacade
 * @group ProcessFacadeTest
 */
class ProcessFacadeTest extends Unit
{
    protected const PATH_INPUT = __DIR__ . '/../_support/facade/process_facade_test.json';

    protected const PATH_OUTPUT = '/tmp/process_facade_output_test.json';

    protected const VALUE_PROCESS_NAME = 'VALUE_PROCESS_NAME';

    protected const VALUE_PROCESS_RESULT = [
        [
            'order_reference' => '11111111',
            'payment' => 'CC',
            'store' => 'DE',
        ],
        [
            'order_reference' => '22222222',
            'payment' => 'CASH',
            'store' => 'GB',
        ],
    ];

    /**
     * @return void
     */
    public function testProcess(): void
    {
        $facade = $this->prepareFacade($this->getContainer());
        $facade->process($this->getProcessSettingsTransfer());

        $result = json_decode(file_get_contents(static::PATH_OUTPUT), true);
        $this->assertEquals(static::VALUE_PROCESS_RESULT, $result);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\ProcessFacade
     */
    protected function getProcessFacade(): ProcessFacade
    {
        return new ProcessFacade();
    }

    /**
     * @return \Generated\Shared\Transfer\ProcessSettingsTransfer
     */
    protected function getProcessSettingsTransfer(): ProcessSettingsTransfer
    {
        $transfer = new ProcessSettingsTransfer();

        $transfer->setName(static::VALUE_PROCESS_NAME);
        $transfer->setInputPath(static::PATH_INPUT);
        $transfer->setOutputPath(static::PATH_OUTPUT);
        $transfer->setIteratorConfig(new IteratorConfigTransfer());
        $transfer->setLoggerConfig(new LoggerConfigTransfer());

        return $transfer;
    }

    /**
     * @return \Spryker\Zed\Kernel\Container
     */
    private function getContainer(): Container
    {
        $container = new Container();
        $container[ProcessDependencyProvider::MIDDLEWARE_CONFIGURATION_PROFILES] = function () {
            return [
                $this->getConfigurationProfilePluginMock(),
            ];
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface
     */
    protected function prepareFacade(Container $container): ProcessFacadeInterface
    {
        $consoleBusinessFactory = new ProcessBusinessFactory();
        $consoleBusinessFactory->setContainer($container);

        $consoleFacade = $this->getProcessFacade();
        $consoleFacade->setFactory($consoleBusinessFactory);

        return $consoleFacade;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getProcessFacadeTestConfigurationMock()
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

        $mock->method('getStagePlugins')->willReturn([new StreamReaderStagePlugin(), $this->getMapperMock(), new StreamWriterStagePlugin()]);
        $mock->method('getIteratorPlugin')->willReturn(new NullIteratorPlugin());
        $mock->method('getLoggerPlugin')->willReturn(new MiddlewareLoggerConfigPlugin());
        $mock->method('getInputStreamPlugin')->willReturn(new JsonInputStreamPlugin());
        $mock->method('getOutputStreamPlugin')->willReturn(new JsonOutputStreamPlugin());
        $mock->method('getPostProcessorHookPlugins')->willReturn([]);
        $mock->method('getPreProcessorHookPlugins')->willReturn([]);
        $mock->method('getProcessName')->willReturn(static::VALUE_PROCESS_NAME);

        return $mock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getConfigurationProfilePluginMock()
    {
        $mock = $this->getMockBuilder(ConfigurationProfilePluginInterface::class)
            ->setMethods([
                'getProcessConfigurationPlugins',
                'getTranslatorFunctionPlugins',
                'getValidatorPlugins',
            ])
            ->disableProxyingToOriginalMethods()
            ->disableOriginalClone()
            ->getMock();

        $mock->method('getProcessConfigurationPlugins')->willReturn([$this->getProcessFacadeTestConfigurationMock()]);
        $mock->method('getTranslatorFunctionPlugins')->willReturn([]);
        $mock->method('getValidatorPlugins')->willReturn([]);

        return $mock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    protected function getMapperMock()
    {
        $mock = $this->getMockBuilder(StagePluginInterface::class)
            ->setMethods([
                'getName',
                'process',
            ])
            ->disableProxyingToOriginalMethods()
            ->disableOriginalClone()
            ->getMock();

        $mock->method('getName')->willReturn('Mapper name');
        $mock->method('process')->willReturnOnConsecutiveCalls(static::VALUE_PROCESS_RESULT[0], static::VALUE_PROCESS_RESULT[1]);

        return $mock;
    }
}
