<?php

namespace SprykerMiddleware\Zed\Process\Business\Mapper\Map;

use Generated\Shared\Transfer\MapperConfigTransfer;

interface MapInterface
{
    const ITEM_MAP = 'itemMap';
    const ITEM_EXCEPT = 'itemExcept';
    const EXCEPT = 'except';

    /**
     * @return \Generated\Shared\Transfer\MaperConfig
     */
    public function getMapperConfig(): MapperConfigTransfer;
}
