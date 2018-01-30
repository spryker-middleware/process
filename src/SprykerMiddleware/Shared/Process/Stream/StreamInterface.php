<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Shared\Process\Stream;

interface StreamInterface
{
    /**
     * @param string $mode
     *
     * @return bool
     */
    public function open(string $mode): bool;

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
