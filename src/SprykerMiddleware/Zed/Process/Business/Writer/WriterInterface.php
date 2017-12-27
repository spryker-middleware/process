<?php

namespace SprykerMiddleware\Zed\Process\Business\Writer;

interface WriterInterface
{
    /**
     * @param resource $outStream
     * @param mixed $payload
     *
     * @return mixed
     */
    public function write($outStream, $payload);
}
