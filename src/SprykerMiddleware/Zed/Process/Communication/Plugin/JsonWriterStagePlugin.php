<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Psr\Log\LoggerInterface;
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
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return mixed
     */
    public function process($payload, LoggerInterface $logger)
    {
        return $this->getFacade()
            ->writeJson($this->outStream, $payload, $logger);
    }
}
