<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Iterator;

use Codeception\Test\Unit;
use ReflectionClass;
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
     * @return \SprykerMiddleware\Zed\Process\Business\Iterator\JsonDirectoryIterator
     */
    protected function getJsonDirectoryIteratorMock(): JsonDirectoryIterator
    {
        $mock = $this->getMockBuilder(JsonDirectoryIterator::class)
            ->setConstructorArgs([$this->getReadStreamMock(), $this->getStreamFactoryMock()])
            ->setMethods(['initJsonStreamForNextItem'])
            ->getMock();

        $mock->method('initJsonStreamForNextItem')->willReturn($this->getJsonReadStream());

        $reflection = new ReflectionClass($mock);
        $reflectionProperty = $reflection->getProperty('jsonStream');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($mock, $this->getJsonReadStream());

        return $mock;
    }

    /**
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    protected function getReadStreamMock(): ReadStreamInterface
    {
        $mock = $this->getMockBuilder(ReadStreamInterface::class)
            ->getMock();
        $mock->method('eof')->willReturn(false);

        return $mock;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface
     */
    protected function getStreamFactoryMock(): StreamFactoryInterface
    {
        return $this->getMockBuilder(StreamFactoryInterface::class)
            ->getMock();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Stream\JsonReadStream
     */
    protected function getJsonReadStream(): JsonReadStream
    {
        return new JsonReadStream(static::VALUE_JSON_PATH);
    }
}
