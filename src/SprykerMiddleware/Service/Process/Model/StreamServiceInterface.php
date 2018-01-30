<?php

namespace SprykerMiddleware\Service\Process\Model;

interface StreamServiceInterface
{
    /**
     * Specification:
     * - Read data from given stream.
     *
     * @api
     *
     * @param resource $stream
     *
     * @return mixed
     */
    public function read($stream);

    /**
     * Specification:
     * - Write given data to given stream.
     *
     * @api
     *
     * @param resource $stream
     * @param mixed $data
     *
     * @return mixed
     */
    public function write($stream, $data);
}
