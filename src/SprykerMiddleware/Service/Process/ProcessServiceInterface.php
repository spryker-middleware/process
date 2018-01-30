<?php

namespace SprykerMiddleware\Service\Process;

interface ProcessServiceInterface
{
    /**
     * Specification:
     * - Read data from given JSON stream.
     *
     * @api
     *
     * @param resource $stream
     *
     * @return array
     */
    public function readJson($stream);

    /**
     * Specification:
     * - Write given data to given JSON stream.
     *
     * @api
     *
     * @param resource $stream
     * @param array $data
     *
     * @return bool|int
     */
    public function writeJson($stream, $data);
}
