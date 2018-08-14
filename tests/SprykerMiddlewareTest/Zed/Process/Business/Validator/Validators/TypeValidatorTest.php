<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Validator\Validators;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Validator\Validators\TypeValidator;
use SprykerMiddleware\Zed\Process\Business\Validator\Validators\ValidatorInterface;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Validator
 * @group Validators
 * @group TypeValidatorTest
 */
class TypeValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidation()
    {
        $validator = new TypeValidator();
        $validator->setOptions(['type' => 'int']);

        $value = 12;
        $this->assertTrue($validator->validate($value, []));

        $value = 'str';
        $this->assertFalse($validator->validate($value, []));

        $validator->setOptions(['type' => 'string']);

        $value = 'str';
        $this->assertTrue($validator->validate($value, []));

        $value = 32;
        $this->assertFalse($validator->validate($value, []));

        $validator->setOptions(['type' => ValidatorInterface::class]);
        $this->assertTrue($validator->validate($validator, []));

        $validator->setOptions(['type' => TypeValidator::class]);
        $this->assertTrue($validator->validate($validator, []));

        $validator->setOptions(['type' => Unit::class]);
        $this->assertFalse($validator->validate($validator, []));
    }
}
