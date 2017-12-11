<?php
namespace  SprykerMiddleware\Zed\Process\Communication\Plugin;

interface StagePluginInterface
{
    /**
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload);
}
