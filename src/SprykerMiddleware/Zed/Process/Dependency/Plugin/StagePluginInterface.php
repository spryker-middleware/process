<?php
namespace SprykerMiddleware\Zed\Process\Dependency\Plugin;

use Psr\Log\LoggerInterface;

interface StagePluginInterface
{
    /**
     * Process the payload.
     *
     * @param mixed $payload
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return mixed
     */
    public function process($payload, LoggerInterface $logger);
}
