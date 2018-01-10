<?php

namespace  SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;
use SprykerMiddleware\Zed\Process\Business\Log\LoggerTrait;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

class Stage implements StageInterface
{
    use LoggerTrait;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface
     */
    protected $stagePlugin;

    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface $stagePlugin
     */
    public function __construct(StagePluginInterface $stagePlugin)
    {
        $this->stagePlugin = $stagePlugin;
    }

    /**
     * @inheritdoc
     */
    public function __invoke($payload, StreamInterface $inStream, StreamInterface $outStream): array
    {
        $this->getLogger()->info('Input Data', [
            'stage' => $this->getStagePluginClass(),
            'input' => $payload,
        ]);

        $processedPayload = $this->stagePlugin
            ->process($payload, $inStream, $outStream);

        $this->getLogger()->info('Result Data', [
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

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface
     */
    public function getStagePlugin(): StagePluginInterface
    {
        return $this->stagePlugin;
    }
}
