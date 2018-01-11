<?php

namespace SprykerMiddleware\Shared\Process\Stream;

interface ReadStreamInterface
{
    /**
     * @return mixed
     */
    public function read();

    /**
     * @return mixed
     */
    public function get();
}
