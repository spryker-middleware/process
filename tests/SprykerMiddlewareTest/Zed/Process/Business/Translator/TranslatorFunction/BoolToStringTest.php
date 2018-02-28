<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\BoolToString;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group BoolToStringTest
 * Add your own group annotations below this line
 */
class BoolToStringTest extends Unit
{
    /**
     * @return void
     */
    public function testBoolToString()
    {
        $converter = new BoolToString();
        $data = true;

        $this->assertEquals('true', $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testBoolToStringWithInteger()
    {
        $converter = new BoolToString();
        $data = 0;

        $this->assertEquals('false', $converter->translate($data, []));
    }
}
