<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Shared\Process\Stream;

interface WriteStreamInterface extends StreamInterface
{
    /**
     * @param array $data
     *
     * @return int
     */
    public function write(array $data): int;

    /**
     * @return bool
     */
    public function flush(): bool;
}
