<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\ArrayToString;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group ArrayToStringTest
 * Add your own group annotations below this line
 */
class ArrayToStringTest extends Unit
{
    /**
     * @return void
     */
    public function testArrayToString()
    {
        $converter = new ArrayToString();
        $data = ['Foo', 'Bar'];

        $this->assertEquals('FooBar', $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testArrayToStringWithGlue()
    {
        $converter = new ArrayToString();
        $converter->setOptions(
            [ArrayToString::OPTION_GLUE => '-']
        );
        $data = ['Foo', 'Bar'];

        $this->assertEquals('Foo-Bar', $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testArrayToStringWithoutArray()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new ArrayToString();
        $converter->setKey('itemKey');
        $data = 'Foo';

        $converter->translate($data, []);
    }
}
