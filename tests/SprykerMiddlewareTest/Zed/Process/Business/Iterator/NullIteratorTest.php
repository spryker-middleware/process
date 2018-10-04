<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Iterator;

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
