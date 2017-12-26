<?php

namespace  SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use Psr\Log\LoggerInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

class Stage implements StageInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface
     */
    protected $stagePlugin;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface $stagePlugin
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(StagePluginInterface $stagePlugin, LoggerInterface $logger)
    {
        $this->stagePlugin = $stagePlugin;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function __invoke($payload): array
    {
        $this->logger->info('Input Data', [
            'stage' => $this->getStagePluginClass(),
            'input' => $payload,
        ]);

        $processedPayload = $this->stagePlugin
            ->process($payload, $this->logger);

        $this->logger->info('Result Data', [
           'stage' => $this->getStagePluginClass(),
           'output' => $processedPayload,
        ]);

        return $processedPayload;
    }

    /**
     * @return string
     */
    protected function getStagePluginClass(): string
    {
        return get_class($this->stagePlugin);
    }
}
