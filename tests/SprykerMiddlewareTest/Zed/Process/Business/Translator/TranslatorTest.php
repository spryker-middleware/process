<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Monolog\Logger;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManager;
use SprykerMiddleware\Zed\Process\Business\Translator\Translator;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionResolver;

/**
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Translator
 * @group TranslatorTest
 */
class TranslatorTest extends Unit
{

    /**
     * @return void
     */
    public function testTranslating()
    {
        $translator = $this->getTranslator($this->getTranslatorConfigTransfer($this->getDictionary()));

        $this->assertEquals($this->getTranslatedPayload(), $translator->translate($this->getOriginalPayload()));
    }

    /**
     * @param \Generated\Shared\Transfer\TranslatorConfigTransfer $translatorConfigTransfer
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\Translator
     */
    protected function getTranslator(TranslatorConfigTransfer $translatorConfigTransfer)
    {
        $loggerMock = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();
        $translator = $this->getMockBuilder(Translator::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([$translatorConfigTransfer, new TranslatorFunctionResolver(), new ArrayManager()])
            ->setMethods(['getLogger'])
            ->getMock();
        $translator->method('getLogger')->willReturn($loggerMock);

        return $translator;
    }

    /**
     * @param array $dictionary
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    protected function getTranslatorConfigTransfer(array $dictionary): TranslatorConfigTransfer
    {
        $translatorConfigTransfer = new TranslatorConfigTransfer();
        $translatorConfigTransfer->setDictionary($dictionary);

        return $translatorConfigTransfer;
    }

    /**
     * @return array
     */
    protected function getOriginalPayload(): array
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
    protected function getTranslatedPayload(): array
    {
        return [
            'categories' => [
                1233,
                1267,
            ],
            'color' => 'white',
            'size' => 'L',
            'names' => [
                'en_GB' => 'name-en',
                'de_DE' => 'name-de',
                'nl_NL' => 'name-nl',
            ],
            'prices' => [
                'en_GB' => 1235,
                'de_DE' => 1250,
                'nl_NL' => 1280,
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getDictionary(): array
    {
        return [
            'prices.*' => function ($price) {
                return (int) ($price * 100);
            },
            'categories.*' => function ($category) {
                $values = ['category1' => 1233, 'category2' => 1267,];
                return isset($values[$category]) ? $values[$category] : null;
            }

    ];
}
}