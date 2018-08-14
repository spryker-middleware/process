<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
