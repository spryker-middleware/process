<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Validator\Validators;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Validator\Validators\LengthValidator;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Validator
 * @group Validators
 * @group LengthValidatorTest
 */
class LengthValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testWithoutOptions()
    {
        $validator = new LengthValidator();
        $validator->setOptions([]);

        $value = 'string';
        $this->assertTrue($validator->validate($value, []));
    }

    /**
     * @return void
     */
    public function testWithMinOption()
    {
        $validator = new LengthValidator();
        $validator->setOptions(['min' => 4]);

        $value = 'string';
        $this->assertTrue($validator->validate($value, []));

        $value = 'text';
        $this->assertTrue($validator->validate($value, []));

        $value = 'str';
        $this->assertFalse($validator->validate($value, []));
    }

    /**
     * @return void
     */
    public function testWithMaxOption()
    {
        $validator = new LengthValidator();
        $validator->setOptions(['max' => 4]);

        $value = 'str';
        $this->assertTrue($validator->validate($value, []));

        $value = 'text';
        $this->assertTrue($validator->validate($value, []));

        $value = 'string';
        $this->assertFalse($validator->validate($value, []));
    }

    /**
     * @return void
     */
    public function testWithMinAndMaxOption()
    {
        $validator = new LengthValidator();
        $validator->setOptions(['max' => 5, 'min' => 3]);

        $value = 'str';
        $this->assertTrue($validator->validate($value, []));

        $value = 'text';
        $this->assertTrue($validator->validate($value, []));

        $value = 'text3';
        $this->assertTrue($validator->validate($value, []));

        $value = 'string';
        $this->assertFalse($validator->validate($value, []));

        $value = 'st';
        $this->assertFalse($validator->validate($value, []));
    }
}
