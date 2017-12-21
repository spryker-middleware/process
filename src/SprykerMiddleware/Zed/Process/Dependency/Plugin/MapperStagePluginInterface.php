<?php

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin;

use Generated\Shared\Transfer\MapperConfigTransfer;

interface MapperStagePluginInterface extends StagePluginInterface
{
    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    public function getMapperConfig(): MapperConfigTransfer;
}
