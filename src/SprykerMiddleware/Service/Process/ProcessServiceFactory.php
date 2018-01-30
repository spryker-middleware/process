<?php

namespace SprykerMiddleware\Service\Process;

use SprykerMiddleware\Service\Process\Model\StreamService;

class ProcessServiceFactory
{
    /**
     * @return \SprykerMiddleware\Service\Process\Model\StreamServiceInterface
     */
    public function createStreamService()
    {
        return new StreamService();
    }
}
