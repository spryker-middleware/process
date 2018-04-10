<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Iterator;

use Codeception\Test\Unit;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Iterator\JsonDirectoryIterator;
use SprykerMiddleware\Zed\Process\Business\Iterator\NullIterator;
use SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface;

class AbstractInteratorTest extends Unit
{
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
    protected function getJsonDirectoryIterator(): JsonDirectoryIterator
    {
        return new JsonDirectoryIterator($this->getReadStreamMock(), $this->getStreamFactoryMock());
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
}
