<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\StringToBool;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group StringToBoolTest
 * Add your own group annotations below this line
 */
class StringToBoolTest extends Unit
{
    /**
     * @return void
     */
    public function testStringToBool()
    {
        $converter = new StringToBool();
        $data = 'True';

        $this->assertEquals(true, $converter->translate($data));
    }

    /**
     * @return void
     */
    public function testStringToBoolWithIntegerString()
    {
        $converter = new StringToBool();
        $data = '0';

        $this->assertEquals(false, $converter->translate($data));
    }

    /**
     * @return void
     */
    public function testStringToBoolWithInteger()
    {
        $converter = new StringToBool();
        $data = 1;

        $this->assertEquals(false, $converter->translate($data));
    }
}
