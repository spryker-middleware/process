<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Generated\Shared\Transfer\TranslatorConfigTransfer;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorStagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
abstract class AbstractTranslatorStagePlugin extends AbstractStagePlugin implements TranslatorStagePluginInterface
{
    /**
     * @inheritdoc
     */
    public function process($payload)
    {
        return $this->getFacade()
            ->translate($payload, $this->getTranslatorConfig());
    }

    /**
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    abstract public function getTranslatorConfig(): TranslatorConfigTransfer;
}
