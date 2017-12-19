<?php

namespace SprykerMiddleware\Zed\Process\Business\Writer;

interface WriterInterface
{
    /**
     * @param mixed $payload
     *
     * @return mixed
     */
    public function write($payload);
}
