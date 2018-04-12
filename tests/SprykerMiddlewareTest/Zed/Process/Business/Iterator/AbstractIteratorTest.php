<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Iterator;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Iterator\JsonDirectoryIterator;
use SprykerMiddleware\Zed\Process\Business\Iterator\NullIterator;
use SprykerMiddleware\Zed\Process\Business\Stream\JsonReadStream;
use SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface;

class AbstractIteratorTest extends Unit
{
    protected const VALUE_JSON_PATH = '/test';

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Iterator\NullIterator
     */
    protected function getNullIterator(): NullIterator
    {
        return new NullIterator($this->getReadStreamMock());
    }

    /**
     * @return MockObject|JsonDirectoryIterator
     */
    protected function getJsonDirectoryIteratorMock(): JsonDirectoryIterator
    {
        $mock = $this->getMockBuilder(JsonDirectoryIterator::class)
            ->setConstructorArgs([$this->getReadStreamMock(), $this->getStreamFactoryMock()])
            ->setMethods(['initJsonStreamForNextItem'])
            ->getMock();

        $mock->method('initJsonStreamForNextItem')->willReturn($this->getJsonReadStream());

        $reflection = new \ReflectionClass($mock);
        $reflectionPropety = $reflection->getProperty('jsonStream');
        $reflectionPropety->setAccessible(true);
        $reflectionPropety->setValue($mock, $this->getJsonReadStream());

        return $mock;
    }

    protected function getReadStreamMock()
    {
        $mock = $this->getMockBuilder(ReadStreamInterface::class)
            ->getMock();
        $mock->method('eof')->willReturn(false);

        return $mock;
    }

    protected function getStreamFactoryMock()
    {
        return $this->getMockBuilder(StreamFactoryInterface::class)
            ->getMock();
    }

    protected function getJsonReadStream()
    {
        return new JsonReadStream(self::VALUE_JSON_PATH);
    }
}
