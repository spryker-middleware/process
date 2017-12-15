<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
abstract class AbstractWriterStagePlugin extends AbstractPlugin implements WriterStagePluginInterface
{
    /**
     * @inheritdoc
     */
    public function process($payload)
    {
        return $this->getFacade()
            ->writeJson($payload, $this->getDestination());
    }
}
