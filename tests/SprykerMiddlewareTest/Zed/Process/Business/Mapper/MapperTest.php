<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\MapperConfigTransfer;
use Monolog\Logger;
use SprykerMiddleware\Shared\Process\ProcessConfig;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManager;
use SprykerMiddleware\Zed\Process\Business\Mapper\Mapper;

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

    /**
     * @return void
     */
    public function testStrategies()
    {
        $mapper = $this->getMapper($this->getMapperConfigTransfer(ProcessConfig::MAPPER_STRATEGY_COPY_UNKNOWN, []));
        $this->assertEquals($this->getOriginalPayload(), $mapper->map($this->getOriginalPayload()));

        $mapper = $this->getMapper($this->getMapperConfigTransfer(ProcessConfig::MAPPER_STRATEGY_SKIP_UNKNOWN, []));
        $this->assertEquals([], $mapper->map($this->getOriginalPayload()));
    }

    /**
     * @return void
     */
    public function testMapping()
    {
        $mapper = $this->getMapper($this->getMapperConfigTransfer(
            ProcessConfig::MAPPER_STRATEGY_SKIP_UNKNOWN,
            $this->getMapping())
        );
        $this->assertEquals($this->getMappedPayload(), $mapper->map($this->getOriginalPayload()));
    }

    /**
     * @param \Generated\Shared\Transfer\MapperConfigTransfer $mapperConfigTransfer
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\Mapper
     */
    protected function getMapper(MapperConfigTransfer $mapperConfigTransfer)
    {
        $loggerMock = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mapper = $this->getMockBuilder(Mapper::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$mapperConfigTransfer, new ArrayManager()])
            ->setMethods(['getLogger'])
            ->getMock();
        $mapper->method('getLogger')->willReturn($loggerMock);

        return $mapper;
    }

    /**
     * @param string $strategy
     * @param array $map
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
     * @return array
     */
    protected function getMappedPayload(): array
    {
        return [
            'categories' => [
                'category1',
                'category2',
            ],
            'color' => 'white',
            'size' => 'L',
            'names' => [
                'en_GB' => 'name-en',
                'de_DE' => 'name-de',
                'nl_NL' => 'name-nl',
            ],
            'prices' => [
                'en_GB' => 12.35,
                'de_DE' => 12.50,
                'nl_NL' => 12.80,
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getMapping(): array
    {
        return [
            'categories' => 'values.categories',
            'color' => 'values.attributes.color',
            'size' => 'values.attributes.size',
            'names' => function ($payload) {
                $result = [];
                foreach ($payload['values']['name'] as $name) {
                    $result[$name['locale']] = $name['name'];
                }

                return $result;
            },
            'prices' => function ($payload) {
                $result = [];
                foreach ($payload['prices'] as $name) {
                    $result[$name['locale']] = $name['price'];
                }

                return $result;
            },
        ];
    }

}