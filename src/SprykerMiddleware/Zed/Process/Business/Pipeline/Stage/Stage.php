<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace  SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use SprykerMiddleware\Shared\Process\Log\MiddlewareLoggerTrait;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

class Stage implements StageInterface
{
    use MiddlewareLoggerTrait;

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
    public function __invoke($payload, WriteStreamInterface $outStream, $originalPayload): array
    {
        $this->getProcessLogger()->info('Input Data', [
            'stage' => $this->getStagePluginClass(),
            'input' => $payload,
        ]);

        $processedPayload = $this->stagePlugin
            ->process($payload, $outStream, $originalPayload);

        $this->getProcessLogger()->info('Result Data', [
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
