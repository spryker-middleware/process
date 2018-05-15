<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Translator\TranslatorFunction;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\StringToArray;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorFunction
 * @group StringToArrayTest
 * Add your own group annotations below this line
 */
class StringToArrayTest extends Unit
{
    /**
     * @return void
     */
    public function testStringToArray()
    {
        $converter = new StringToArray();
        $converter->setOptions(
            [StringToArray::OPTION_DELIMITER => '-']
        );
        $data = 'Foo-Bar';

        $this->assertEquals(['Foo', 'Bar'], $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testStringToArrayWithIntegerString()
    {
        $converter = new StringToArray();
        $converter->setOptions(
            [StringToArray::OPTION_DELIMITER => '-']
        );
        $data = '12';

        $this->assertEquals(['12'], $converter->translate($data, []));
    }

    /**
     * @return void
     */
    public function testStringToArrayWithFloat()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException');

        $converter = new StringToArray();
        $converter->setKey('itemKey');
        $converter->setOptions(
            [StringToArray::OPTION_DELIMITER => '-']
        );
        $data = 12.0;

        $this->assertEquals(['12'], $converter->translate($data, []));
    }
}
