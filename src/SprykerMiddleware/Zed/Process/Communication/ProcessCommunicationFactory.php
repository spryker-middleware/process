<?php
namespace SprykerMiddleware\Zed\Process\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerMiddleware\Zed\Process\Business\Iterator\IteratorFactory;

/**
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 */
class ProcessCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Iterator\IteratorFactory
     */
    public function createIteratorFactory(): IteratorFactory
    {
        return new IteratorFactory();
    }
}
