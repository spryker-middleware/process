<?php

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin;

use Generated\Shared\Transfer\TranslatorConfigTransfer;

interface TranslatorStagePluginInterface extends StagePluginInterface
{
    /**
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    public function getTranslatorConfig(): TranslatorConfigTransfer;
}
