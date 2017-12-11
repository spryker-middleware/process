<?php

namespace  SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface;

class Stage implements StageInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface
     */
    protected $stagePlugin;

    /**
     * @param \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface $stagePlugin
     */
    public function __construct(StagePluginInterface $stagePlugin)
    {
        $this->stagePlugin = $stagePlugin;
    }

    /**
     * @inheritdoc
     */
    public function __invoke($payload)
    {
        return $this->stagePlugin
            ->process($payload);
    }
}
