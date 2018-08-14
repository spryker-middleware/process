<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\IntToString;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group IntToStringTest
 * Add your own group annotations below this line
 */
class IntToStringTest extends Unit
{
    /**
     * @return void
     */
    public function testIntToString()
    {
        $converter = new IntToString();
        $data = 12;

        $this->assertEquals('12', $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testIntToStringWithFloat()
    {
        $converter = new IntToString();
        $data = 12.2;

        $this->assertEquals('12.2', $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testIntToStringWithTextString()
    {
        $converter = new IntToString();
        $data = 'FooBar';

        $this->assertEquals('FooBar', $converter->translate($data, []));
    }
}
