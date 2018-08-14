<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\ExcludeValuesSequentalFilter;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group ExcludeValuesSequentalFilterTest
 * Add your own group annotations below this line
 */
class ExcludeValuesSequentalFilterTest extends Unit
{
    /**
     * @return void
     */
    public function testExcludeValuesSequentalFilter()
    {
        $excludeValues = [
            'baz',
            'bar',
        ];

        $converter = new ExcludeValuesSequentalFilter();
        $converter->setOptions(
            ['excludeValues' => $excludeValues]
        );

        $data = [
            'bar',
            'baz',
            'foobar',
        ];

        $this->assertEquals(['foobar'], $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testExcludeValuesSequentalFilterOnAssociativeArray()
    {
        $excludeValues = [
            'baz',
            'bar',
        ];

        $converter = new ExcludeValuesSequentalFilter();
        $converter->setOptions(
            ['excludeValues' => $excludeValues]
        );

        $data = [
            'foo' => 'bar',
            'bar' => 'baz',
            'baz' => 'foobar',
        ];

        $this->assertEquals(['foobar'], $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testExcludeValuesSequentalFilterWithoutArray()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new ExcludeValuesSequentalFilter();
        $converter->setKey('itemKey');
        $data = 'foo';

        $converter->translate($data, []);
    }
}
