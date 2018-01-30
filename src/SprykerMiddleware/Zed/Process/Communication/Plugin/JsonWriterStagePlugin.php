<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
class JsonWriterStagePlugin extends AbstractStagePlugin implements StagePluginInterface
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
        $this->getFacade()
            ->writeJson($this->outStream, $payload);
        return $payload;
    }
}
