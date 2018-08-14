<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Service\Process\Model;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface StreamServiceInterface
{
    /**
     * Stream service interface.
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $stream
     *
     * @return mixed
     */
    public function read(ReadStreamInterface $stream);

    /**
     * Stream service interface.
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $stream
     * @param mixed $data
     *
     * @return mixed
     */
    public function write(WriteStreamInterface $stream, $data);
}
