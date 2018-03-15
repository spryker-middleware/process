<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Generated\Shared\Transfer\MapperConfigTransfer;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\MapperStagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
abstract class AbstractMapperStagePlugin extends AbstractStagePlugin implements MapperStagePluginInterface
{
    /**
     * @inheritdoc
     */
    public function process($payload, WriteStreamInterface $outStream, $originalPayload)
    {
        return $this->getFacade()
            ->map($payload, $this->getMapperConfig());
    }

    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    abstract public function getMapperConfig(): MapperConfigTransfer;
}
