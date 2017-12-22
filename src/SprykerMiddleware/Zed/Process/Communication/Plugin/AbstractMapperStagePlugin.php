<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\MapperStagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
abstract class AbstractMapperStagePlugin extends AbstractPlugin implements MapperStagePluginInterface
{
    /**
     * @inheritdoc
     */
    public function process($payload, LoggerInterface $logger)
    {
        return $this->getFacade()
            ->map($payload, $this->getMapperConfig(), $logger);
    }

    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    abstract public function getMapperConfig(): MapperConfigTransfer;
}
