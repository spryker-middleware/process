<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\FloatToString;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group FloatToStringTest
 * Add your own group annotations below this line
 */
class FloatToStringTest extends Unit
{
    /**
     * @return void
     */
    public function testFloatToString()
    {
        $converter = new FloatToString();
        $data = '12.2';

        $this->assertEquals(12.2, $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testFloatToStringWithFloat()
    {
        $converter = new FloatToString();
        $data = 12.2;

        $this->assertEquals('12.2', $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testFloatToStringWithTextString()
    {
        $converter = new FloatToString();
        $data = 'FooBar';

        $this->assertEquals('FooBar', $converter->translate($data, []));
    }
}
