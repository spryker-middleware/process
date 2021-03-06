<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\IntToFloat;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group IntToFloatTest
 * Add your own group annotations below this line
 */
class IntToFloatTest extends Unit
{
    /**
     * @return void
     */
    public function testIntToFloat()
    {
        $converter = new IntToFloat();
        $data = 12;

        $this->assertEquals(12, $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testIntToFloatWithFloat()
    {
        $converter = new IntToFloat();
        $data = 12.2;

        $this->assertEquals('12.2', $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testIntToFloatWithTextString()
    {
        $converter = new IntToFloat();
        $data = 'FooBar';

        $this->assertEquals('0.0', $converter->translate($data, []));
    }
}
