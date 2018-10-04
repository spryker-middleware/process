<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\MoneyDecimalToInteger;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group MoneyDecimalToIntegerTest
 * Add your own group annotations below this line
 */
class MoneyDecimalToIntegerTest extends Unit
{
    /**
     * @return void
     */
    public function testMoneyDecimalToInteger()
    {
        $converter = new MoneyDecimalToInteger();
        $data = 12.0;

        $this->assertEquals('1200', $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testMoneyDecimalToIntegerWithFloatString()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new MoneyDecimalToInteger();
        $converter->setKey('itemKey');
        $data = '12.2';

        $converter->translate($data, []);
    }

    /**
     * @return void
     */
    public function testMoneyDecimalToIntegerWithTextString()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new MoneyDecimalToInteger();
        $converter->setKey('itemKey');
        $data = 'FooBar';

        $converter->translate($data, []);
    }
}
