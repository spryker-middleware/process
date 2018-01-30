<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Generated\Shared\Transfer\TranslatorConfigTransfer;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorStagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
abstract class AbstractTranslatorStagePlugin extends AbstractStagePlugin implements TranslatorStagePluginInterface
{
    /**
     * @inheritdoc
     */
    public function process($payload, ReadStreamInterface $inStream, WriteStreamInterface $outStream)
    {
        return $this->getFacade()
            ->translate($payload, $this->getTranslatorConfig());
    }

    /**
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    abstract public function getTranslatorConfig(): TranslatorConfigTransfer;
}
