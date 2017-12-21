<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\Enum;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group EnumTest
 * Add your own group annotations below this line
 */
class EnumTest extends Unit
{
    /**
     * @return void
     */
    public function testEnum()
    {
        $map = [
            'test' => 'foo',
        ];

        $converter = new Enum();
        $converter->setOptions(
            ['map' => $map]
        );

        $data = 'test';

        $this->assertEquals($map[$data], $converter->translate($data));
    }

    /**
     * @return void
     */
    public function testEnumWithInteger()
    {
        $map = [
            'foo',
        ];

        $converter = new Enum();
        $converter->setOptions(
            ['map' => $map]
        );

        $data = 0;

        $this->assertEquals($map[$data], $converter->translate($data));
    }

    /**
     * @return void
     */
    public function testEnumWithReturnArray()
    {
        $map = [
            ['foo']
        ];

        $converter = new Enum();
        $converter->setOptions(
            ['map' => $map]
        );

        $data = 0;

        $this->assertEquals($map[$data], $converter->translate($data));
    }
}
