<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\StringToInt;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group StringToIntTest
 * Add your own group annotations below this line
 */
class StringToIntTest extends Unit
{
    /**
     * @return void
     */
    public function testStringToInt()
    {
        $converter = new StringToInt();
        $data = '12.98';

        $this->assertEquals(12, $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testStringToIntWithString()
    {
        $converter = new StringToInt();
        $data = 'FooBar';

        $this->assertEquals(0, $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testStringToIntWithInteger()
    {
        $converter = new StringToInt();
        $data = 12;

        $this->assertEquals(12, $converter->translate($data, []));
    }
}
