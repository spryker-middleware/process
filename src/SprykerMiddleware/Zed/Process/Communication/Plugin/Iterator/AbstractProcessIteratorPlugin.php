<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator;

use Generated\Shared\Transfer\IteratorSettingsTransfer;
use Iterator;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface;

abstract class AbstractProcessIteratorPlugin extends AbstractPlugin implements ProcessIteratorPluginInterface
{
    const PLUGIN_NAME = 'SPRYKER_MIDDLEWARE_ABSTRACT_ITERATOR_PLUGIN';

    /**
     * @param resource $inStream
     * @param \Generated\Shared\Transfer\IteratorSettingsTransfer $iteratorSettingsTransfer
     *
     * @return \Iterator
     */
    abstract public function getIterator($inStream, IteratorSettingsTransfer $iteratorSettingsTransfer): Iterator;

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
