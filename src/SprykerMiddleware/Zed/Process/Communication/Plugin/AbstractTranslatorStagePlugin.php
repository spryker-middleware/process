<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorStagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
abstract class AbstractTranslatorStagePlugin extends AbstractPlugin implements TranslatorStagePluginInterface
{
    /**
     * @inheritdoc
     */
    public function process($payload, LoggerInterface $logger)
    {
        return $this->getFacade()
            ->translate($payload, $this->getTranslatorConfig(), $logger);
    }

    /**
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    abstract public function getTranslatorConfig(): TranslatorConfigTransfer;
}
