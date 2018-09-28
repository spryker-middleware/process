<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\StringToFloat;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group StringToFloatTest
 * Add your own group annotations below this line
 */
class StringToFloatTest extends Unit
{
    /**
     * @return void
     */
    public function testStringToFloat()
    {
        $converter = new StringToFloat();
        $data = '12.98';

        $this->assertEquals(12.98, $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testStringToFloatWithString()
    {
        $converter = new StringToFloat();
        $data = 'FooBar';

        $this->assertEquals(0.0, $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testStringToFloatWithInteger()
    {
        $converter = new StringToFloat();
        $data = 12;

        $this->assertEquals(12.00, $converter->translate($data, []));
    }
}
