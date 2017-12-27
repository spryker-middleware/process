<?php

namespace SprykerMiddleware\Service\Process;

interface ProcessServiceInterface
{
    /**
     * @param resource $stream
     *
     * @return array
     */
    public function readJson($stream);

    /**
     * @param resource $stream
     * @param array $data
     *
     * @return bool|int
     */
    public function writeJson($stream, $data);
}
