<?php

namespace SprykerMiddleware\Service;

use SprykerMiddleware\Service\Model\JsonStreamService;

class ProcessServiceFactory
{
    /**
     * @return \SprykerMiddleware\Service\Model\StreamServiceInterface
     */
    public function createJsonStreamService()
    {
        return new JsonStreamService();
    }
}
