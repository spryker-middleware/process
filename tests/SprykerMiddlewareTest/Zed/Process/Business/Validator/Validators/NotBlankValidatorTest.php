<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Validator\Validators;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Validator\Validators\NotBlankValidator;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Validator
 * @group Validators
 * @group NotBlankValidatorTest
 */
class NotBlankValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidation()
    {
        $validator = new NotBlankValidator();
        $validator->setKey('validationKey');

        $this->assertFalse($validator->validate('', ['validationKey' => '']));

        $this->assertTrue($validator->validate(30, ['validationKey' => 30]));

        $this->assertFalse($validator->validate(null, ['validationKey' => null]));

        $this->assertFalse($validator->validate([], ['validationKey' => []]));

        $this->assertTrue($validator->validate(10, ['key' => []]));
    }
}
