<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use Iterator;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

interface IteratorFactoryInterface
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     *
     * @return \Iterator
     */
    public function createNullIterator(ReadStreamInterface $inStream): Iterator;
}