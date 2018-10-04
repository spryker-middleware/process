<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Validator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ValidatorConfigTransfer;
use Monolog\Logger;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManager;
use SprykerMiddleware\Zed\Process\Business\Validator\PayloadValidator;
use SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\Resolver\ValidatorPluginResolver;

/**
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Validator
 * @group PayloadValidatorTest
 */
class PayloadValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidCase()
    {
        $payloadValidator = $this->getValidator();

        $this->assertEquals($this->getValidPayload(), $payloadValidator->validate($this->getValidPayload(), $this->getValidatorConfigTransfer($this->getRules())));
    }

    /**
     * @return void
     */
    public function testInvalidCase()
    {
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\InvalidItemException');

        $payloadValidator = $this->getValidator();

        $payloadValidator->validate($this->getInvalidPayload(), $this->getValidatorConfigTransfer($this->getRules()));
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Validator\PayloadValidator
     */
    protected function getValidator()
    {
        $loggerMock = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();
        $payloadValidator = $this->getMockBuilder(PayloadValidator::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([new ValidatorPluginResolver([]), new ArrayManager()])
            ->setMethods(['getProcessLogger'])
            ->getMock();
        $payloadValidator->method('getProcessLogger')->willReturn($loggerMock);

        return $payloadValidator;
    }

    /**
     * @param array $rules
     *
     * @return \Generated\Shared\Transfer\ValidatorConfigTransfer
     */
    protected function getValidatorConfigTransfer(array $rules): ValidatorConfigTransfer
    {
        $validatorConfigTransfer = new ValidatorConfigTransfer();
        $validatorConfigTransfer->setRules($rules);

        return $validatorConfigTransfer;
    }

    /**
     * @return array
     */
    protected function getValidPayload(): array
    {
        return [
            'categories' => [
                'category1',
                'category2',
            ],
            'color' => 'white',
            'size' => 'L',
            'names' => [
                'en_GB' => 'name-en',
                'de_DE' => 'name-de',
                'nl_NL' => 'name-nl',
            ],
            'prices' => [
                'en_GB' => 12.35,
                'de_DE' => 12.50,
                'nl_NL' => 12.80,
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getInvalidPayload(): array
    {
        return [
            'categories' => [
                'category1',
                'category2',
            ],
            'color' => 'green',
            'size' => 'L',
            'names' => [
                'en_GB' => 'name-en',
                'de_DE' => 'name-de',
                'nl_NL' => 'name-nl',
            ],
            'prices' => [
                'en_GB' => 12.35,
                'de_DE' => 12.50,
                'nl_NL' => 12.80,
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getRules()
    {
        return [
            'color' => function ($value, $payload) {
                return $value === 'white';
            },
            'names' => function ($value, $payload) {
                return is_array($value) && count($value) > 2;
            },
        ];
    }
}
