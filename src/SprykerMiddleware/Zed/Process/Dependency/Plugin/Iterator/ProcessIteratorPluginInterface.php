<?php

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator;

use Generated\Shared\Transfer\IteratorSettingsTransfer;
use Iterator;

interface ProcessIteratorPluginInterface
{
    /**
     * @param resource $inStream
     * @param \Generated\Shared\Transfer\IteratorSettingsTransfer $iteratorSettingsTransfer
     *
     * @return \Iterator
     */
    public function getIterator($inStream, IteratorSettingsTransfer $iteratorSettingsTransfer): Iterator;
}
