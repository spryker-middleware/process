<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Psr\Log\LoggerInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorStagePluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
abstract class AbstractTranslatorStagePlugin extends AbstractStagePlugin implements TranslatorStagePluginInterface
{
    /**
     * @inheritdoc
     */
    public function process($payload, LoggerInterface $logger)
    {
        return $this->getFacade()
            ->translate($payload, $this->getTranslatorConfig(), $logger);
    }
}
