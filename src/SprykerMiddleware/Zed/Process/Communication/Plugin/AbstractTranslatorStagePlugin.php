<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin;

use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

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
            ->translate($payload, $this->getDictionary(), $logger);
    }
}
