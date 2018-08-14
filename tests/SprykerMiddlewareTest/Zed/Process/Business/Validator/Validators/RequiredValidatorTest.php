<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Validator\Validators;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Validator\Validators\RequiredValidator;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Validator
 * @group Validators
 * @group RequiredValidatorTest
 */
class RequiredValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidation()
    {
        $validator = new RequiredValidator();
        $validator->setKey('validateKey');

        $value = 12;
        $this->assertTrue($validator->validate($value, ['validateKey' => $value]));

        $value = null;
        $this->assertFalse($validator->validate($value, []));
    }
}
