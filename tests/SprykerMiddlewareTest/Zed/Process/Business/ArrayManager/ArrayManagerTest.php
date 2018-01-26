<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\ArrayManager;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManager;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface;

/**
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group ArrayManager
 * @group ArrayManagerTest
 */
class ArrayManagerTest extends Unit
{

    /**
     * @return void
     */
    public function testGetValueByKey()
    {
        $arrayManager = $this->getArrayManager();

        $this->assertEquals('white', $arrayManager->getValueByKey($this->getArray(), 'values.attributes.color'));
        $this->assertEquals('L', $arrayManager->getValueByKey($this->getArray(), 'values.attributes.size'));
        $this->assertEquals(['category1', 'category2'], $arrayManager->getValueByKey($this->getArray(), 'values.categories'));

        $this->assertNull($arrayManager->getValueByKey($this->getArray(), 'unknown key'));
    }

    /**
     * @return void
     */
    public function testPutValue()
    {
        $arrayManager = $this->getArrayManager();
        $payload = $this->getArray();

        $payload = $arrayManager->putValue($payload, 'foo.bar', 'value');
        $payload = $arrayManager->putValue($payload, 'values.attributes.size', 2);
        $payload = $arrayManager->putValue($payload, 'sku', '123456');

        $this->assertEquals('value', $payload['foo']['bar']);
        $this->assertEquals(2, $payload['values']['attributes']['size']);
        $this->assertEquals('123456', $payload['sku']);
    }

    /**
     * @return void
     */
    public function testGetAllNestedKeys()
    {
        $arrayManager = $this->getArrayManager();
        $keys = $arrayManager->getAllNestedKeys($this->getArray(), 'prices.*');
        $this->assertEquals(['prices.0', 'prices.1', 'prices.2'], $keys);

        $keys = $arrayManager->getAllNestedKeys($this->getArray(), 'prices.*.*');
        $this->assertEquals(['prices.0.locale', 'prices.0.price', 'prices.1.locale', 'prices.1.price','prices.2.locale', 'prices.2.price',], $keys);

        $keys = $arrayManager->getAllNestedKeys($this->getArray(), 'prices.*.name');
        $this->assertEquals(['prices.0.name', 'prices.1.name', 'prices.2.name'], $keys);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface
     */
    protected function getArrayManager(): ArrayManagerInterface
    {
        return new ArrayManager();
    }

    /**
     * @return array
     */
    protected function getArray(): array
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

}