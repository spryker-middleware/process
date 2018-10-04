<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Validator\Validators;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Validator\Validators\EqualToValidator;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Validator
 * @group Validators
 * @group EqualToValidatorTest
 */
class EqualToValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidation()
    {
        $validator = new EqualToValidator();
        $validator->setOptions(['value' => ['id' => 33]]);
        $value = ['id' => 33];

        $this->assertTrue($validator->validate($value, []));

        $value = ['id' => 34];

        $this->assertFalse($validator->validate($value, []));
    }
}
