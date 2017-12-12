<?php


namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

interface TranslatorStagePluginInterface extends StagePluginInterface
{
    /**
     * @return array
     */
    public function getDictionary(): array;
}
