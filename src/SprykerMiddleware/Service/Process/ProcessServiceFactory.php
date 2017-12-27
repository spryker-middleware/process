<?php

namespace SprykerMiddleware\Service\Process;

use SprykerMiddleware\Service\Process\Model\JsonStreamService;

class ProcessServiceFactory
{
    /**
     * @return \SprykerMiddleware\Service\Process\Model\StreamServiceInterface
     */
    public function createJsonStreamService()
    {
        return new JsonStreamService();
    }
}
