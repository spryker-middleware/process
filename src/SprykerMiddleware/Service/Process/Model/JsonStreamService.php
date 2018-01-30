<?php

namespace SprykerMiddleware\Service\Process\Model;

class JsonStreamService implements JsonStreamServiceInterface
{
    /**
     * @param resource $stream
     *
     * @return array
     */
    public function read($stream)
    {
        return json_decode(fgets($stream), true);
    }

    /**
     * @param resource $stream
     * @param array $data
     *
     * @return bool|int
     */
    public function write($stream, $data)
    {
        return fwrite($stream, json_encode($data));
    }
}
