<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use DateTime;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\StringToDateTime;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group StringToDateTimeTest
 * Add your own group annotations below this line
 */
class StringToDateTimeTest extends Unit
{
    /**
     * @return void
     */
    public function testStringToDateTime()
    {
        $converter = new StringToDateTime();
        $data = '2017-12-31';

        $this->assertEquals(new DateTime($data), $converter->translate($data));
    }

    /**
     * @return void
     */
    public function testStringToDateTimeWithIntegerString()
    {
        $this->expectException('Exception');

        $converter = new StringToDateTime();
        $data = '0';

        $converter->translate($data);
    }

    /**
     * @return void
     */
    public function testStringToDateTimeWithInteger()
    {
        $this->expectException('Exception');

        $converter = new StringToDateTime();
        $data = 1;

        $converter->translate($data);
    }
}
