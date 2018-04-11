<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Iterator;

use SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException;

/**
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Iterator
 * @group NullIteratorTest
 */
class NullIteratorTest extends AbstractIteratorTest
{
    /**
     * @return void
     */
    public function testCurrent(): void
    {
        $nullIterator = $this->getNullIterator();
        $this->assertEquals($nullIterator->current(), $this->getReadStreamMock());
    }

    /**
     * @return void
     */
    public function testNext(): void
    {
        $nullIterator = $this->getNullIterator();
        $this->assertEquals($nullIterator->next(), $this->getReadStreamMock());
    }

    /**
     * @return void
     */
    public function testKey(): void
    {
        $nullIterator = $this->getNullIterator();
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException');
        $nullIterator->key();
    }

    /**
     * @return void
     */
    public function testValid(): void
    {
        $nullIterator = $this->getNullIterator();
        $this->assertEquals($nullIterator->valid(), true);
    }
}
