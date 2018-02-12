<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */


namespace SprykerMiddleware\Zed\Process\Business\Stream;


interface StreamFactoryInterface
{
    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface|\SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createJsonStream(string $path);

}