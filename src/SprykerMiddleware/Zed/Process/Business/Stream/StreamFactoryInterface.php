<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapterInterface;

interface StreamFactoryInterface
{
    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function createJsonReadStream(string $path): ReadStreamInterface;

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createJsonWriteStream(string $path): WriteStreamInterface;

    /**
     * @param string $path
     * @param string $delimiter
     * @param string $enclosure
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function createCsvReadStream(string $path, string $delimiter = ',', string $enclosure = '"'): ReadStreamInterface;

    /**
     * @param string $path
     * @param string $rootNodeName
     * @param \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapterInterface $decoder
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function createXmlReadStream(string $path, string $rootNodeName, ProcessToSymfonyDecoderAdapterInterface $decoder): ReadStreamInterface;

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function createDirectoryStream(string $path);

    /**
     * @param string $path
     * @param array $header
     * @param string $delimiter
     * @param string $enclosure
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createCsvWriteStream(string $path, array $header = [], string $delimiter = ',', string $enclosure = '"'): WriteStreamInterface;
}
