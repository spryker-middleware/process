<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Psr\Log\LoggerInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\MapperStagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
abstract class AbstractMapperStagePlugin extends AbstractStagePlugin implements MapperStagePluginInterface
{
    /**
     * @inheritdoc
     */
    public function process($payload, LoggerInterface $logger)
    {
        return $this->getFacade()
            ->map($payload, $this->getMapperConfig(), $logger);
    }
}
