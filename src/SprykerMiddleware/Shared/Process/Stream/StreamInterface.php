<?php

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
     * @param int $length
     *
     * @return mixed
     */
    public function read($length);

    /**
     * @return mixed
     */
    public function get();

    /**
     * @param mixed $data
     *
     * @return int
     */
    public function write($data): int;

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
     */
    public function seek($offset, $whence): int;

    /**
     * @return bool
     */
    public function flush(): bool;

    /**
     * @return bool
     */
    public function eof(): bool;
}
