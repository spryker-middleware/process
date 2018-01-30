<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator;

use Generated\Shared\Transfer\IteratorSettingsTransfer;
use Iterator;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class NullIteratorPlugin extends AbstractPlugin implements ProcessIteratorPluginInterface
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
