<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Stream\XmlStringNormalizer\XmlStringNormalizer;
use SprykerMiddleware\Zed\Process\Business\Stream\XmlStringNormalizer\XmlStringNormalizerInterface;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapterInterface;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapterInterface;

class StreamFactory implements StreamFactoryInterface
{
    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function createJsonReadStream(string $path): ReadStreamInterface
    {
        return new JsonReadStream($path);
    }

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function createJsonRowReadStream(string $path): ReadStreamInterface
    {
        return new JsonRowReadStream($path);
    }

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createJsonWriteStream(string $path): WriteStreamInterface
    {
        return new JsonWriteStream($path);
    }

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createJsonRowWriteStream(string $path): WriteStreamInterface
    {
        return new JsonRowWriteStream($path);
    }

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function createDirectoryStream(string $path)
    {
        return new DirectoryStream($path);
    }

    /**
     * @param string $path
     * @param string $delimiter
     * @param string $enclosure
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function createCsvReadStream(string $path, string $delimiter = ',', string $enclosure = '"'): ReadStreamInterface
    {
        return new CsvReadStream($path, $delimiter, $enclosure);
    }

    /**
     * @param string $path
     * @param string $rootNodeName
     * @param \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapterInterface $decoder
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function createXmlReadStream(string $path, string $rootNodeName, ProcessToSymfonyDecoderAdapterInterface $decoder): ReadStreamInterface
    {
        return new XmlReadStream($path, $rootNodeName, $decoder);
    }

    /**
     * @param string $path
     * @param array $header
     * @param string $delimiter
     * @param string $enclosure
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createCsvWriteStream(string $path, array $header = [], string $delimiter = ',', string $enclosure = '"'): WriteStreamInterface
    {
        return new CsvWriteStream($path, $header, $delimiter, $enclosure);
    }

    /**
     * @param string $path
     * @param string $rootNodeName
     * @param string $entityNodeName
     * @param \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapterInterface $encoder
     * @param string|null $version
     * @param string|null $encoding
     * @param string|null $standalone
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createXmlWriteStream(string $path, string $rootNodeName, string $entityNodeName, ProcessToSymfonyEncoderAdapterInterface $encoder, ?string $version = null, ?string $encoding = null, ?string $standalone = null): WriteStreamInterface
    {
        return new XmlWriteStream($path, $rootNodeName, $entityNodeName, $encoder, $this->createXmlStringNormalizer(), $version, $encoding, $standalone);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Stream\XmlStringNormalizer\XmlStringNormalizerInterface
     */
    public function createXmlStringNormalizer(): XmlStringNormalizerInterface
    {
        return new XmlStringNormalizer();
    }
}
