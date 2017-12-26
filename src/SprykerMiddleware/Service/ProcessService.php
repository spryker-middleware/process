<?php

namespace SprykerMiddleware\Service;

use Spryker\Service\Kernel\AbstractService;

/**
 * @method \SprykerMiddleware\Service\ProcessServiceFactory getFactory();
 */
class ProcessService extends AbstractService implements ProcessServiceInterface
{
    /**
     * @param resource $stream
     * @param int $length
     *
     * @return mixed
     */
    public function readJson($stream, $length = 1)
    {
        return $this->getFactory()
            ->createJsonStreamService()
            ->read($stream, $length);
    }

    /**
     * @param resource $stream
     * @param mixed $data
     *
     * @return mixed
     */
    public function writeJson($stream, $data)
    {
        return $this->getFactory()
            ->createJsonStreamService()
            ->write($stream, $data);
    }
}
