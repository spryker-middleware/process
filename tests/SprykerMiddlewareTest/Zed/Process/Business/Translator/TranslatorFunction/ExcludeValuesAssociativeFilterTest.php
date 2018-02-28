<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\ExcludeValuesAssociativeFilter;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group ExcludeValuesAssociativeFilterTest
 * Add your own group annotations below this line
 */
class ExcludeValuesAssociativeFilterTest extends Unit
{
    /**
     * @return void
     */
    public function testExcludeValuesAssociativeFilter()
    {
        $excludeValues = [
            'baz',
            'bar',
        ];

        $converter = new ExcludeValuesAssociativeFilter();
        $converter->setOptions(
            ['excludeValues' => $excludeValues]
        );

        $data = [
            'foo' => 'bar',
            'bar' => 'baz',
            'baz' => 'foobar',
        ];

        $this->assertEquals(['baz' => 'foobar'], $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testExcludeValuesAssociativeFilterOnSequentalArray()
    {
        $excludeValues = [
            'baz',
            'bar',
        ];

        $converter = new ExcludeValuesAssociativeFilter();
        $converter->setOptions(
            ['excludeValues' => $excludeValues]
        );

        $data = [
            'foo',
            'bar',
            'baz',
            'foobar',
        ];

        $this->assertEquals(['0' => 'foo', '3' => 'foobar'], $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testExcludeValuesAssociativeFilterWithoutArray()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new ExcludeValuesAssociativeFilter();
        $converter->setKey('itemKey');
        $data = 'foo';

        $converter->translate($data, []);
    }
}
