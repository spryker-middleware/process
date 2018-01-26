<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator;

use Generated\Shared\Transfer\IteratorConfigTransfer;
use Iterator;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class NullIteratorPlugin extends AbstractPlugin implements ProcessIteratorPluginInterface
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     * @param \Generated\Shared\Transfer\IteratorConfigTransfer $iteratorConfigTransfer
     *
     * @return \Iterator
     */
    public function getIterator(ReadStreamInterface $inStream, IteratorConfigTransfer $iteratorConfigTransfer): Iterator
    {
        return $this->getFactory()
            ->createIteratorFactory()
            ->createNullIterator($inStream);
    }
}
