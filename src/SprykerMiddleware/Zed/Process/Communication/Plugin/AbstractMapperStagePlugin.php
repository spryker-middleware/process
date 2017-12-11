<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
abstract class AbstractMapperStagePlugin extends AbstractPlugin implements MapperStagePluginInterface
{
    /**
     * @inheritdoc
     */
    public function process($payload)
    {
        return $this->getFacade()
            ->map($payload, $this->getMap());
    }
}
