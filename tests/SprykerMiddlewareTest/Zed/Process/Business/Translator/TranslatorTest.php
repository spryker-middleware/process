<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Mapper;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Monolog\Logger;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManager;
use SprykerMiddleware\Zed\Process\Business\Translator\Translator;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionPluginResolver;

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
        $translator = $this->getTranslator();

        $this->assertEquals($this->getTranslatedPayload(), $translator->translate($this->getOriginalPayload(), $this->getTranslatorConfigTransfer($this->getDictionary())));
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\Translator
     */
    protected function getTranslator()
    {
        $loggerMock = $this->getMockBuilder(Logger::class)
            ->disableOriginalConstructor()
            ->getMock();
        $translator = $this->getMockBuilder(Translator::class)
            ->enableOriginalConstructor()
            ->setConstructorArgs([new TranslatorFunctionPluginResolver([]), new ArrayManager()])
            ->setMethods(['getProcessLogger'])
            ->getMock();
        $translator->method('getProcessLogger')->willReturn($loggerMock);

        return $translator;
    }

    /**
     * @param array $dictionary
     *
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
                return (int)($price * 100);
            },
            'categories.*' => function ($category) {
                $values = ['category1' => 1233, 'category2' => 1267];
                return isset($values[$category]) ? $values[$category] : null;
            },

        ];
    }
}
