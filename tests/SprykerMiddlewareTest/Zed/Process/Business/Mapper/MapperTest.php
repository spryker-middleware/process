<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\MapperConfigTransfer;
use Monolog\Logger;
use SprykerMiddleware\Shared\Logger\Logger\MiddlewareLoggerTrait;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManager;
use SprykerMiddleware\Zed\Process\Business\Mapper\ClosureMapper;
use SprykerMiddleware\Zed\Process\Business\Mapper\DynamicMapper;
use SprykerMiddleware\Zed\Process\Business\Mapper\KeyMapper;
use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;
use SprykerMiddleware\Zed\Process\Business\Mapper\Payload\PayloadMapper;
use SprykerMiddleware\Zed\Process\Business\ProcessBusinessFactory;
use SprykerMiddleware\Zed\Process\Business\ProcessFacade;
use SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule\ArrayMapRulePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule\ClosureMapRulePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule\DynamicArrayMapRulePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule\DynamicMapRulePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule\KeyMapRulePlugin;

/**
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Mapper
 * @group MapperTest
 */
class MapperTest extends Unit
{
    use MiddlewareLoggerTrait;

    /**
     * @return void
     */
    public function testStrategies()
    {
        $mapper = $this->getMapper();
        $this->assertEquals($this->getOriginalPayload(), $mapper->map($this->getOriginalPayload(), $this->getMapperConfigTransfer(MapInterface::MAPPER_STRATEGY_COPY_UNKNOWN, [])));

        $mapper = $this->getMapper();
        $this->assertEquals([], $mapper->map($this->getOriginalPayload(), $this->getMapperConfigTransfer(MapInterface::MAPPER_STRATEGY_SKIP_UNKNOWN, [])));
    }

    /**
     * @return void
     */
    public function testKeyMapper(): void
    {
        $mapper = $this->getMapper();

        $this->assertEquals($mapper->map($this->getOriginalPayload(), $this->getMapperConfigTransfer(
            MapInterface::MAPPER_STRATEGY_SKIP_UNKNOWN,
            [
                'categories' => 'values.categories',
            ]
        )), [
            'categories' => [
                'category1',
                'category2',
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testClosureMapper(): void
    {
        $mapper = $this->getMapper();

        $this->assertEquals($mapper->map($this->getOriginalPayload(), $this->getMapperConfigTransfer(
            MapInterface::MAPPER_STRATEGY_SKIP_UNKNOWN,
            [
                'names' => function ($payload) {
                    $result = [];
                    foreach ($payload['values']['name'] as $name) {
                        $result[$name['locale']] = $name['name'];
                    }

                    return $result;
                },
            ]
        )), [
            'names' => [
                'en_GB' => 'name-en',
                'de_DE' => 'name-de',
                'nl_NL' => 'name-nl',
            ],
        ]);
    }

    /**
     * @return void
     */
    public function testDynamicMapper(): void
    {
        $mapper = $this->getMapper();

        $this->assertEquals($mapper->map($this->getOriginalPayload(), $this->getMapperConfigTransfer(
            MapInterface::MAPPER_STRATEGY_SKIP_UNKNOWN,
            [
                '&values.attributes.color' => 'values.attributes.color',
            ]
        )), [
            'white' => 'white',
        ]);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\Payload\PayloadMapper
     */
    protected function getMapper()
    {
        $mapper = $this->getMockBuilder(PayloadMapper::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([new ArrayManager(), $this->getMapperPluginsStack()])
            ->setMethods(['getProcessLogger'])
            ->getMock();

        $mapper->method('getProcessLogger')->willReturn($this->getLoggerMock());

        return $mapper;
    }

    /**
     * @return array
     */
    protected function getMapperPluginsStack(): array
    {
        $facade = $this->getFacade();
        $dynamicArrayMapRulePluginMock = $this->getMockBuilder(DynamicArrayMapRulePlugin::class)
            ->enableOriginalConstructor()
            ->setMethods(['getFacade'])
            ->getMock();
        $dynamicArrayMapRulePluginMock->method('getFacade')->willReturn($facade);

        $closureRuleMapPluginMock = $this->getMockBuilder(ClosureMapRulePlugin::class)
            ->enableOriginalConstructor()
            ->setMethods(['getFacade'])
            ->getMock();
        $closureRuleMapPluginMock->method('getFacade')->willReturn($facade);

        $arrayMapRulePluginMock = $this->getMockBuilder(ArrayMapRulePlugin::class)
            ->enableOriginalConstructor()
            ->setMethods(['getFacade'])
            ->getMock();
        $arrayMapRulePluginMock->method('getFacade')->willReturn($facade);

        $dynamicMapRulePluginMock = $this->getMockBuilder(DynamicMapRulePlugin::class)
            ->enableOriginalConstructor()
            ->setMethods(['getFacade'])
            ->getMock();
        $dynamicMapRulePluginMock->method('getFacade')->willReturn($facade);

        $keyMapRulePluginMock = $this->getMockBuilder(KeyMapRulePlugin::class)
            ->enableOriginalConstructor()
            ->setMethods(['getFacade'])
            ->getMock();
        $keyMapRulePluginMock->method('getFacade')->willReturn($facade);

        return [
            $dynamicArrayMapRulePluginMock,
            $closureRuleMapPluginMock,
            $arrayMapRulePluginMock,
            $dynamicMapRulePluginMock,
            $keyMapRulePluginMock,
        ];
    }

    /**
     * @param string $strategy
     * @param array $map
     *
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    protected function getMapperConfigTransfer(string $strategy, array $map): MapperConfigTransfer
    {
        $mapperConfigTransfer = new MapperConfigTransfer();
        $mapperConfigTransfer->setStrategy($strategy);
        $mapperConfigTransfer->setMap($map);

        return $mapperConfigTransfer;
    }

    /**
     * @return array
     */
    protected function getOriginalPayload(): array
    {
        return [
            'prices' => [
                [
                    'locale' => 'en_GB',
                    'price' => 12.35,
                ],
                [
                    'locale' => 'de_DE',
                    'price' => 12.50,
                ],
                [
                    'locale' => 'nl_NL',
                    'price' => 12.80,
                ],
            ],
            'delivery' => [
                [
                    'locale' => 'en_GB',
                    'is_allowed' => true,
                ],
                [
                    'locale' => 'de_DE',
                    'is_allowed' => false,
                ],
            ],
            'values' => [
                'attributes' => [
                    'color' => 'white',
                    'size' => 'L',
                ],
                'name' => [
                    [
                        'locale' => 'en_GB',
                        'name' => 'name-en',
                    ],
                    [
                        'locale' => 'de_DE',
                        'name' => 'name-de',
                    ],
                    [
                        'locale' => 'nl_NL',
                        'name' => 'name-nl',
                    ],
                ],
                'categories' => [
                    'category1',
                    'category2',
                ],
            ],
        ];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\ProcessFacade
     */
    protected function getFacade()
    {
        $facade = new ProcessFacade();

        $factory = $this->getMockBuilder(ProcessBusinessFactory::class)
            ->setMethods(['createKeyMapper', 'createDynamicArrayMapper', 'createArrayMapper', 'createDynamicMapper', 'createClosureMapper'])
            ->getMock();

        $factory->method('createKeyMapper')->willReturn($this->getKeyMapperMock());
        $factory->method('createDynamicMapper')->willReturn($this->getDynamicMapperMock());
        $factory->method('createClosureMapper')->willReturn($this->getClosureMapperMock());

        $facade->setFactory($factory);

        return $facade;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\KeyMapper
     */
    protected function getKeyMapperMock()
    {
        $mock = $this->getMockBuilder(KeyMapper::class)
            ->setConstructorArgs([new ArrayManager()])
            ->setMethods(['getProcessLogger'])
            ->getMock();
        $mock->method('getProcessLogger')->willReturn($this->getLoggerMock());

        return $mock;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\DynamicMapper
     */
    protected function getDynamicMapperMock()
    {
        $mock = $this->getMockBuilder(DynamicMapper::class)
            ->setConstructorArgs([new ArrayManager()])
            ->setMethods(['getProcessLogger'])
            ->getMock();
        $mock->method('getProcessLogger')->willReturn($this->getLoggerMock());

        return $mock;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\ClosureMapper
     */
    protected function getClosureMapperMock()
    {
        $mock = $this->getMockBuilder(ClosureMapper::class)
            ->setConstructorArgs([new ArrayManager()])
            ->setMethods(['getProcessLogger'])
            ->getMock();
        $mock->method('getProcessLogger')->willReturn($this->getLoggerMock());

        return $mock;
    }

    /**
     * @return \Monolog\Logger
     */
    protected function getLoggerMock()
    {
        $loggerMock = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $loggerMock;
    }
}
