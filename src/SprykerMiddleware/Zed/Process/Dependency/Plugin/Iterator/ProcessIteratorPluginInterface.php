<?php

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator;

use Generated\Shared\Transfer\IteratorConfigTransfer;
use Iterator;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

interface ProcessIteratorPluginInterface
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     * @param \Generated\Shared\Transfer\IteratorConfigTransfer $iteratorConfigTransfer
     *
     * @return \Iterator
     */
    public function getIterator(ReadStreamInterface $inStream, IteratorConfigTransfer $iteratorConfigTransfer): Iterator;
}
