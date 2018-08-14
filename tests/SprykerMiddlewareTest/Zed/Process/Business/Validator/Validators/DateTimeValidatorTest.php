<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Validator\Validators;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Validator\Validators\DateTimeValidator;

/**
 * Auto-generated group annotations
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Validator
 * @group Validators
 * @group DateTimeValidatorTest
 */
class DateTimeValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testWithDefaultFormat()
    {
        $validator = new DateTimeValidator();
        $value = '2017-03-22 08:33:33';

        $this->assertTrue($validator->validate($value, []));

        $value = '03/22/2017 08:33:33';

        $this->assertFalse($validator->validate($value, []));
    }

    /**
     * @return void
     */
    public function testWithSpecifiedFormat()
    {
        $validator = new DateTimeValidator();
        $validator->setOptions(['format' => 'm/d/Y H:i:s']);
        $value = '2017-03-22 08:33:33';

        $this->assertFalse($validator->validate($value, []));

        $value = '03/22/2017 08:33:33';

        $this->assertTrue($validator->validate($value, []));
    }
}
