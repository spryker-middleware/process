<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class JsonReaderStagePlugin extends AbstractPlugin implements StagePluginInterface
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
        return $this->getFacade()->readJson($payload, $logger);
    }
}
