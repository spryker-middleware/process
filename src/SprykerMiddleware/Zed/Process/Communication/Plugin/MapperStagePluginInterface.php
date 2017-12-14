<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;

interface MapperStagePluginInterface extends StagePluginInterface
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface
     */
    public function getMap(): MapInterface;
}
