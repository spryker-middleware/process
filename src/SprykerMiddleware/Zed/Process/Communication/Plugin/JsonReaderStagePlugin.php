<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class JsonReaderStagePlugin extends AbstractStagePlugin implements StagePluginInterface
{
    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload)
    {
        return $this->getFacade()
            ->readJson($this->inStream);
    }
}
