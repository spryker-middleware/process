<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use DateTime;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\DateTimeToString;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group DateTimeToStringTest
 * Add your own group annotations below this line
 */
class DateTimeToStringTest extends Unit
{
    /**
     * @return void
     */
    public function testDateTimeToString()
    {
        $format = 'd/m/Y H:i:s';

        $converter = new DateTimeToString();
        $converter->setOptions(
            ['format' => $format]
        );
        $data = new DateTime();

        $this->assertEquals($data->format($format), $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testDateTimeToStringWithInteger()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new DateTimeToString();
        $converter->setKey('itemKey');
        $data = 0;

        $converter->translate($data, []);
    }

    /**
     * @return void
     */
    public function testDateTimeToStringWithArray()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new DateTimeToString();
        $converter->setKey('itemKey');
        $data = ['Foo'];

        $converter->translate($data, []);
    }

    /**
     * @return void
     */
    public function testDateTimeToStringWithString()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new DateTimeToString();
        $converter->setKey('itemKey');
        $data = 'Foo';

        $converter->translate($data, []);
    }
}
