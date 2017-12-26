<?php

namespace SprykerMiddleware\Service;

interface ProcessServiceInterface
{
    /**
     * @param resource $stream
     * @param int $length
     *
     * @return mixed
     */
    public function readJson($stream, $length = 1);

    /**
     * @param resource $stream
     * @param mixed $data
     *
     * @return mixed
     */
    public function writeJson($stream, $data);
}
