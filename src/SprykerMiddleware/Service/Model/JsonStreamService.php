<?php

namespace SprykerMiddleware\Service\Model;

class JsonStreamService implements StreamServiceInterface
{
    const READ_LENGTH = 1;

    /**
     * @param resource $stream
     * @param int $length
     *
     * @return mixed
     */
    public function read($stream, $length)
    {
        return json_decode(fread($stream, static::READ_LENGTH), true);
    }

    /**
     * @param resource $stream
     * @param mixed $data
     *
     * @return mixed
     */
    public function write($stream, $data)
    {
        return fwrite($stream, json_encode($data));
    }
}
