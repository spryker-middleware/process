<?php

namespace SprykerMiddleware\Service\Process;

use Spryker\Service\Kernel\AbstractService;
use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

/**
 * @method \SprykerMiddleware\Service\Process\ProcessServiceFactory getFactory();
 */
class ProcessService extends AbstractService implements ProcessServiceInterface
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $stream
     *
     * @return array
     */
    public function readJson(StreamInterface $stream)
    {
        return $this->getFactory()
            ->createJsonStreamService()
            ->read($stream);
    }

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $stream
     * @param array $data
     *
     * @return bool|int
     */
    public function writeJson(StreamInterface $stream, $data)
    {
        return $this->getFactory()
            ->createJsonStreamService()
            ->write($stream, $data);
    }
}
