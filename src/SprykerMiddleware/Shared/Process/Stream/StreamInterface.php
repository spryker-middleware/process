<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Shared\Process\Stream;

interface StreamInterface
{
    /**
     * @return bool
     */
    public function open(): bool;

    /**
     * @return bool
     */
    public function close(): bool;

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
     */
    public function seek(int $offset, int $whence): int;

    /**
     * @return bool
     */
    public function eof(): bool;
}
