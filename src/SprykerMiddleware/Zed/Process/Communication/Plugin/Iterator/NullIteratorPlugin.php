<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator;

use Generated\Shared\Transfer\IteratorSettingsTransfer;
use Iterator;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class NullIteratorPlugin extends AbstractProcessIteratorPlugin
{
    const PLUGIN_NAME = 'SPRYKER_MIDDLEWARE_NULL_ITERATOR_PLUGIN';

    /**
     * @param resource $inStream
     * @param \Generated\Shared\Transfer\IteratorSettingsTransfer $iteratorSettingsTransfer
     *
     * @return \Iterator
     */
    public function getIterator($inStream, IteratorSettingsTransfer $iteratorSettingsTransfer): Iterator
    {
        return $this->getFactory()
            ->createIteratorFactory()
            ->createNullIterator($inStream);
    }
}
