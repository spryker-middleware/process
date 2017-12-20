<?php

namespace SprykerMiddleware\Zed\Process\Business\Mapper\Map;

use Generated\Shared\Transfer\MapperConfigTransfer;

interface MapInterface
{
    /**
     * @return \Generated\Shared\Transfer\MaperConfig
     */
    public function getMapperConfig(): MapperConfigTransfer;
}
