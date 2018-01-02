<?php

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use Iterator;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class IteratorFactory extends AbstractBusinessFactory
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
