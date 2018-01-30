<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class JsonReaderStagePlugin extends AbstractStagePlugin implements StagePluginInterface
{
    const PLUGIN_NAME = 'SPRYKER_MIDDLEWARE_JSON_READER_STAGE_PLUGIN';

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

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
