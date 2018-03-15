<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\PluginResolver;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Exception\ProcessConfigurationNotFoundException;
use SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolver;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;

/**
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group PluginResolver
 * @group PluginResolverTest
 */
class PluginResolverTest extends Unit
{
    const PROCESS_1 = 'process1';
    const PROCESS_2 = 'process2';
    const PROCESS_3 = 'process3';
    const PROCESS_4 = 'process4';
    const UNKNOWN_PROCESS = 'unknownProcess';

    /**
     * @return void
     */
    public function testGetProcessConfigurationPluginByProcessName()
    {
        $pluginResolver = new ProcessPluginResolver($this->getConfigurationProfilePluginsStackMock());
        $processPlugin = $pluginResolver->getProcessConfigurationPluginByProcessName(static::PROCESS_1);

        $this->assertEquals(static::PROCESS_1, $processPlugin->getProcessName());
    }

    /**
     * @return void
     */
    public function testProcessConfigurationPluginNotFound()
    {
        $this->expectException(ProcessConfigurationNotFoundException::class);

        $pluginResolver = new ProcessPluginResolver($this->getConfigurationProfilePluginsStackMock());
        $processPlugin = $pluginResolver->getProcessConfigurationPluginByProcessName(static::UNKNOWN_PROCESS);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[]
     */
    protected function getConfigurationProfilePluginsStackMock(): array
    {
        $mock1 = $this->getMockBuilder(ConfigurationProfilePluginInterface::class)
            ->setMethods(['getProcessConfigurationPlugins', 'getValidatorPlugins', 'getTranslatorFunctionPlugins'])
            ->disableProxyingToOriginalMethods()
            ->getMock();
        $mock1->method('getProcessConfigurationPlugins')->willReturn($this->mockProcessConfigurationPlugins([static::PROCESS_1, static::PROCESS_2]));

        $mock2 = $this->getMockBuilder(ConfigurationProfilePluginInterface::class)
            ->setMethods(['getProcessConfigurationPlugins', 'getValidatorPlugins', 'getTranslatorFunctionPlugins'])
            ->disableProxyingToOriginalMethods()
            ->getMock();
        $mock2->method('getProcessConfigurationPlugins')->willReturn($this->mockProcessConfigurationPlugins([static::PROCESS_3, static::PROCESS_4]));

        return [$mock1, $mock2];
    }

    /**
     * @param array $processNames
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    protected function mockProcessConfigurationPlugins(array $processNames): array
    {
        $list = [];
        foreach ($processNames as $processName) {
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
            $mock->method('getProcessName')->willReturn($processName);

            $list[] = $mock;
        }

        return $list;
    }
}
