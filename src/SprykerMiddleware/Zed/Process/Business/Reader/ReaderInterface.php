<?php

namespace SprykerMiddleware\Zed\Process\Business\Reader;

interface ReaderInterface
{
    /**
     * @param resource $inStream
     *
     * @return array
     */
    public function read($inStream): array;
}
