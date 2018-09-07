<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Service\Process;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface ProcessServiceInterface
{
    /**
     * Specification:
     * - Read data from given stream.
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $stream
     *
     * @return mixed
     */
    public function read(ReadStreamInterface $stream);

    /**
     * Specification:
     * - Write given data to given stream.
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $stream
     * @param mixed $data
     *
     * @return int
     */
    public function write(WriteStreamInterface $stream, $data): int;
}
