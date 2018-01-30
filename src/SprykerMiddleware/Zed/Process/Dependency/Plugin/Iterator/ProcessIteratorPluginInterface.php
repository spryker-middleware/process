<?php

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator;

use Generated\Shared\Transfer\IteratorSettingsTransfer;
use Iterator;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

interface ProcessIteratorPluginInterface
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     * @param \Generated\Shared\Transfer\IteratorSettingsTransfer $iteratorSettingsTransfer
     *
     * @return \Iterator
     */
    public function getIterator(ReadStreamInterface $inStream, IteratorSettingsTransfer $iteratorSettingsTransfer): Iterator;

    /**
     * @return string
     */
    public function getName(): string;
}
