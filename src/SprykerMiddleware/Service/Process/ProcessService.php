<?php

namespace SprykerMiddleware\Service\Process;

use Spryker\Service\Kernel\AbstractService;

/**
 * @method \SprykerMiddleware\Service\Process\ProcessServiceFactory getFactory();
 */
class ProcessService extends AbstractService implements ProcessServiceInterface
{
    /**
     * @param resource $stream
     *
     * @return array
     */
    public function readJson($stream)
    {
        return $this->getFactory()
            ->createJsonStreamService()
            ->read($stream);
    }

    /**
     * @param resource $stream
     * @param array $data
     *
     * @return bool|int
     */
    public function writeJson($stream, $data)
    {
        return $this->getFactory()
            ->createJsonStreamService()
            ->write($stream, $data);
    }
}
