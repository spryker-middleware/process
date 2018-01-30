<?php

namespace SprykerMiddleware\Service\Process;

use Spryker\Service\Kernel\AbstractService;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

/**
 * @method \SprykerMiddleware\Service\Process\ProcessServiceFactory getFactory();
 */
class ProcessService extends AbstractService implements ProcessServiceInterface
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $stream
     *
     * @return array
     */
    public function read(ReadStreamInterface $stream)
    {
        return $this->getFactory()
            ->createStreamService()
            ->read($stream);
    }

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $stream
     * @param array $data
     *
     * @return bool|int
     */
    public function write(WriteStreamInterface $stream, $data)
    {
        return $this->getFactory()
            ->createStreamService()
            ->write($stream, $data);
    }
}
