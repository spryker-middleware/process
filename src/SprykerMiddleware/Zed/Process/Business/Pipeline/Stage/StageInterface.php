<?php
namespace  SprykerMiddleware\Zed\Process\Business\Pipeline\Stage;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

interface StageInterface
{
    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function __invoke($payload);

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface
     */
    public function getStagePlugin(): StagePluginInterface;
}
