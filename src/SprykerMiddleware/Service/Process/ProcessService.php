<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

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
     * {@inheritdoc}
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $stream
     *
     * @return mixed
     */
    public function read(ReadStreamInterface $stream)
    {
        return $this->getFactory()
            ->createStreamService()
            ->read($stream);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $stream
     * @param mixed $data
     *
     * @return int
     */
    public function write(WriteStreamInterface $stream, $data): int
    {
        return $this->getFactory()
            ->createStreamService()
            ->write($stream, $data);
    }
}
