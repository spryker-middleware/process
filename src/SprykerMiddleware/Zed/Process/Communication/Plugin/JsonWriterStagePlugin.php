<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
class JsonWriterStagePlugin extends AbstractStagePlugin implements StagePluginInterface
{
    const PLUGIN_NAME = 'SPRYKER_MIDDLEWARE_JSON_WRITER_STAGE_PLUGIN';

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

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
