<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;

abstract class AbstractTranslatorStagePlugin extends AbstractPlugin implements TranslatorStagePluginInterface
{
    /**
     * @inheritdoc
     */
    public function process($payload)
    {
        return $this->getFacade()
            ->translate($payload, $this->getDictionary());
    }
}
