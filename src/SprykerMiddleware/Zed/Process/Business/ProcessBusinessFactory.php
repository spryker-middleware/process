<?php

namespace SprykerMiddleware\Zed\Process\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerMiddleware\Zed\Process\Business\Mapper\Mapper;
use SprykerMiddleware\Zed\Process\Business\Mapper\MapperInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 */
class ProcessBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @param array $map
     *
     * @return \SPrykerMiddleware\Zed\Process\Business\Mapper\MapperInterface
     */
    public function createMapper($map): MapperInterface
    {
        return new Mapper($map);
    }
}
