<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\FloatToInt;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group FloatToIntTest
 * Add your own group annotations below this line
 */
class FloatToIntTest extends Unit
{
    /**
     * @return void
     */
    public function testFloatToInt()
    {
        $converter = new FloatToInt();
        $data = 12.2;

        $this->assertEquals(12, $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testFloatToIntWithFloatString()
    {
        $converter = new FloatToInt();
        $data = '12.2';

        $this->assertEquals('12', $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testFloatToIntWithTextString()
    {
        $converter = new FloatToInt();
        $data = 'FooBar';

        $this->assertEquals('0', $converter->translate($data, []));
    }
}
