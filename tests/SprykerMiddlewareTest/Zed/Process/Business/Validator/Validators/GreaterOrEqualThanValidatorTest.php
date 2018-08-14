<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Validator\Validators;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Validator\Validators\GreaterOrEqualThanValidator;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Validator
 * @group Validators
 * @group GreaterOrEqualThanValidatorTest
 */
class GreaterOrEqualThanValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidation()
    {
        $validator = new GreaterOrEqualThanValidator();
        $validator->setOptions(['value' => 40]);

        $value = 40;
        $this->assertTrue($validator->validate($value, []));

        $value = 42;
        $this->assertTrue($validator->validate($value, []));

        $value = 34;
        $this->assertFalse($validator->validate($value, []));
    }
}
