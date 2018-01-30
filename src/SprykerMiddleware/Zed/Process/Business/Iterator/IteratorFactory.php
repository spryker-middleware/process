<?php

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use Iterator;

class IteratorFactory
{
    /**
     * @param resource $inStream
     *
     * @return \Iterator
     */
    public function createNullIterator($inStream): Iterator
    {
        return new NullIterator($inStream);
    }
}
