<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Generated\Shared\Transfer\MapperConfigTransfer;
use SprykerMiddleware\Shared\Process\Stream\StreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\MapperStagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
abstract class AbstractMapperStagePlugin extends AbstractStagePlugin implements MapperStagePluginInterface
{
    /**
     * @inheritdoc
     */
    public function process($payload, StreamInterface $inStream, StreamInterface $outStream)
    {
        return $this->getFacade()
            ->map($payload, $this->getMapperConfig());
    }

    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    abstract public function getMapperConfig(): MapperConfigTransfer;
}
