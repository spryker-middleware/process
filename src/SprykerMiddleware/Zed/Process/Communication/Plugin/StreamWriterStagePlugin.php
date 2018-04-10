<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class StreamWriterStagePlugin extends AbstractStagePlugin implements StagePluginInterface
{
    protected const PLUGIN_NAME = 'StreamWriterStagePlugin';

    /**
     * @inheritdoc
     */
    public function process($payload, WriteStreamInterface $outStream, $originalPayload)
    {
        $this->getFactory()
            ->getProcessService()
            ->write($outStream, $payload);

        return $payload;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::STAGE_TYPE_WRITER;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
