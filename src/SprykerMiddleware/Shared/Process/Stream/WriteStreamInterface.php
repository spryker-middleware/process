<?php

namespace SprykerMiddleware\Shared\Process\Stream;

interface WriteStreamInterface
{
    /**
     * @param mixed $data
     *
     * @return int
     */
    public function write($data): int;

    /**
     * @return bool
     */
    public function flush(): bool;
}
