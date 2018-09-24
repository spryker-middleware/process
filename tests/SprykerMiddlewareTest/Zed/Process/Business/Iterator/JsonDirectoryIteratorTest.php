<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Iterator;

/**
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Iterator
 * @group JsonDirectoryIteratorTest
 */
class JsonDirectoryIteratorTest extends AbstractIteratorTest
{
    /**
     * @return void
     */
    public function testCurrent(): void
    {
        $jsonDirectoryIterator = $this->getJsonDirectoryIteratorMock();
        $this->assertEquals($this->getJsonReadStream(), $jsonDirectoryIterator->current());
    }

    /**
     * @return void
     */
    public function testNext(): void
    {
        $jsonDirectoryIterator = $this->getJsonDirectoryIteratorMock();
        $this->assertEquals($jsonDirectoryIterator->next(), null);
    }

    /**
     * @return void
     */
    public function testKey(): void
    {
        $jsonDirectoryIterator = $this->getJsonDirectoryIteratorMock();
        $this->expectException('SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException');
        $jsonDirectoryIterator->key();
    }

    /**
     * @return void
     */
    public function testValid(): void
    {
        $jsonDirectoryIterator = $this->getJsonDirectoryIteratorMock();
        $this->assertEquals($jsonDirectoryIterator->valid(), true);
    }
}
