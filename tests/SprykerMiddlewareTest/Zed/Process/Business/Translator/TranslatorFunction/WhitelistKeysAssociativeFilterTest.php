<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\WhitelistKeysAssociativeFilter;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group WhitelistKeysAssociativeFilterTest
 * Add your own group annotations below this line
 */
class WhitelistKeysAssociativeFilterTest extends Unit
{
    /**
     * @return void
     */
    public function testWhitelistKeysAssociativeFilter()
    {
        $whitelistKeys = [
            'foo',
            'bar',
        ];

        $converter = new WhitelistKeysAssociativeFilter();
        $converter->setOptions(
            ['whitelistKeys' => $whitelistKeys]
        );

        $data = [
            'foo' => 'bar',
            'bar' => 'baz',
            'baz' => 'foobar',
        ];

        $this->assertEquals(['foo' => 'bar', 'bar' => 'baz'], $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testWhitelistKeysAssociativeFilterOnSequentalArray()
    {
        $whitelistKeys = [
            '1',
            '2',
        ];

        $converter = new WhitelistKeysAssociativeFilter();
        $converter->setOptions(
            ['whitelistKeys' => $whitelistKeys]
        );

        $data = [
            'foo',
            'bar',
            'baz',
            'foobar',
        ];

        $this->assertEquals(['1' => 'bar', '2' => 'baz'], $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testWhitelistKeysAssociativeFilterWithoutArray()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new WhitelistKeysAssociativeFilter();
        $converter->setKey('itemKey');
        $data = 'foo';

        $converter->translate($data, []);
    }
}
