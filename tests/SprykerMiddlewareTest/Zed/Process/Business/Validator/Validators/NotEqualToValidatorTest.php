<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Validator\Validators;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Validator\Validators\NotEqualToValidator;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Validator
 * @group Validators
 * @group NotEqualToValidatorTest
 */
class NotEqualToValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidation()
    {
        $validator = new NotEqualToValidator();
        $validator->setOptions(['value' => ['id' => 33]]);
        $value = ['id' => 34];

        $this->assertTrue($validator->validate($value, []));

        $value = ['id' => 33];

        $this->assertFalse($validator->validate($value, []));
    }
}
