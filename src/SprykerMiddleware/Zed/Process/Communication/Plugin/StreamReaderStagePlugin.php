<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class StreamReaderStagePlugin extends AbstractPlugin implements StagePluginInterface
{
    protected const PLUGIN_NAME = 'StreamReaderStagePlugin';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param mixed $inputStream
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param mixed $originalPayload
     *
     * @return mixed
     */
    public function process($inputStream, WriteStreamInterface $outStream, $originalPayload)
    {
        return $this->getFactory()
            ->getProcessService()
            ->read($inputStream);
    }

    /**
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
