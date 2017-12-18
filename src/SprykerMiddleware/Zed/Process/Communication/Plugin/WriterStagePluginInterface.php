<?php


namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

interface WriterStagePluginInterface extends StagePluginInterface
{
    /**
     * @return string
     */
    public function getDestination(): string;
}
