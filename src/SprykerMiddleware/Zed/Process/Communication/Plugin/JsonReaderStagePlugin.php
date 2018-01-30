<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class JsonReaderStagePlugin extends AbstractStagePlugin implements StagePluginInterface
{
    const PLUGIN_NAME = 'SPRYKER_MIDDLEWARE_JSON_READER_STAGE_PLUGIN';

    /**
     * @inheritdoc
     */
    public function process($payload, ReadStreamInterface $inStream, WriteStreamInterface $outStream)
    {
        return $this->getFactory()
            ->getProcessService()
            ->read($inStream);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
