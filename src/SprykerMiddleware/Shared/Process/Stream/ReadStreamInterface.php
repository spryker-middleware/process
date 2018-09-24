<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Shared\Process\Stream;

interface ReadStreamInterface extends StreamInterface
{
    public const STATUS_SEEK_SUCCESS = 1;
    public const STATUS_SEEK_FAIL = 0;

    /**
     * @return mixed
     */
    public function read();
}
