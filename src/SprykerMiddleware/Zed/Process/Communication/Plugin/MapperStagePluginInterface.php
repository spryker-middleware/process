<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

interface MapperStagePluginInterface extends StagePluginInterface
{
    /**
     * @return array
     */
    public function getMap(): array;
}
