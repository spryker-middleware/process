<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

interface IteratorFactoryInterface
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Iterator\IteratorInterface
     */
    public function createNullIterator(ReadStreamInterface $inStream): IteratorInterface;

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Iterator\IteratorInterface
     */
    public function createJsonDirectoryIterator(ReadStreamInterface $inStream): IteratorInterface;
}
