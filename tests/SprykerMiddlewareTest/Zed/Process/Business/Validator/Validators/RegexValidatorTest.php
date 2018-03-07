<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Validator\Validators;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Validator\Validators\RegexValidator;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Validator
 * @group Validators
 * @group RegexValidatorTest
 */
class RegexValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidation()
    {
        $validator = new RegexValidator();
        $validator->setOptions(['pattern' => '/^\d{6}$/']);
        $value = 124123;
        $this->assertTrue($validator->validate($value, []));

        $value = 'text for validate';

        $this->assertFalse($validator->validate($value, []));
    }
}
