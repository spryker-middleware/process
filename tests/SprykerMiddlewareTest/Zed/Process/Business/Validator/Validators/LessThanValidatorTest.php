<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Validator\Validators;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Validator\Validators\LessThanValidator;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Validator
 * @group Validators
 * @group LessThanValidatorTest
 */
class LessThanValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidation()
    {
        $validator = new LessThanValidator();
        $validator->setOptions(['value' => 40]);

        $value = 40;
        $this->assertFalse($validator->validate($value, []));

        $value = 30;
        $this->assertTrue($validator->validate($value, []));

        $value = 50;
        $this->assertFalse($validator->validate($value, []));
    }
}
