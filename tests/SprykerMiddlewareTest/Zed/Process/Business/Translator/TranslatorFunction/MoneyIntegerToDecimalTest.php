<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\MoneyIntegerToDecimal;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group MoneyIntegerToDecimalTest
 * Add your own group annotations below this line
 */
class MoneyIntegerToDecimalTest extends Unit
{
    /**
     * @return void
     */
    public function testMoneyIntegerToDecimal()
    {
        $converter = new MoneyIntegerToDecimal();
        $data = 1200;

        $this->assertEquals('12.00', $converter->translate($data));
    }

    /**
     * @return void
     */
    public function testMoneyIntegerToDecimalWithIntegerString()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new MoneyIntegerToDecimal();
        $data = '1200';

        $converter->translate($data);
    }

    /**
     * @return void
     */
    public function testMoneyIntegerToDecimalWithTextString()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new MoneyIntegerToDecimal();
        $data = 'FooBar';

        $converter->translate($data);
    }
}
