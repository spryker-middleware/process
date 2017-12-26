<?php

namespace SprykerMiddleware\Service\Model;

interface StreamServiceInterface
{
    /**
     * @param resource $stream
     * @param int $length
     *
     * @return mixed
     */
    public function read($stream, $length);

    /**
     * @param resource $stream
     * @param mixed $data
     *
     * @return mixed
     */
    public function write($stream, $data);
}
