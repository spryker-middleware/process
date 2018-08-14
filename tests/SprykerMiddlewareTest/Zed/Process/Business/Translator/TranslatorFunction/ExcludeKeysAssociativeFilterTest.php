<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\ExcludeKeysAssociativeFilter;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group ExcludeKeysAssociativeFilterTest
 * Add your own group annotations below this line
 */
class ExcludeKeysAssociativeFilterTest extends Unit
{
    /**
     * @return void
     */
    public function testExcludeKeysAssociativeFilter()
    {
        $excludeKeys = [
            'foo',
            'bar',
        ];

        $converter = new ExcludeKeysAssociativeFilter();
        $converter->setOptions(
            ['excludeKeys' => $excludeKeys]
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
    public function testExcludeKeysAssociativeFilterOnSequentalArray()
    {
        $excludeKeys = [
            '1',
            '2',
        ];

        $converter = new ExcludeKeysAssociativeFilter();
        $converter->setOptions(
            ['excludeKeys' => $excludeKeys]
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
    public function testExcludeKeysAssociativeFilterWithoutArray()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new ExcludeKeysAssociativeFilter();
        $converter->setKey('itemKey');
        $data = 'foo';

        $converter->translate($data, []);
    }
}
