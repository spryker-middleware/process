<?php

namespace SprykerMiddleware\Service\Process\Model;

interface StreamServiceInterface
{
    /**
     * @param resource $stream
     *
     * @return mixed
     */
    public function read($stream);

    /**
     * @param resource $stream
     * @param mixed $data
     *
     * @return mixed
     */
    public function write($stream, $data);
}
