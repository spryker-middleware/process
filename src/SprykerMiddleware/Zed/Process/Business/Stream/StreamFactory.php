<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createJsonWriteStream(string $path): WriteStreamInterface
    {
        return new JsonWriteStream($path);
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
     * @param string $rootNodeName
     * @param string $entityNodeName
     * @param string $version
     * @param string $encoding
     * @param string $standalone
     * @param \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapterInterface $encoder
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createXmlWriteStream(string $path, string $rootNodeName, string $entityNodeName, string $version, string $encoding, string $standalone, ProcessToSymfonyEncoderAdapterInterface $encoder): WriteStreamInterface
    {
        return new XmlWriteStream($path, $rootNodeName, $entityNodeName, $version, $encoding, $standalone, $encoder, $this->createXmlStringNormalizer());
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Stream\XmlStringNormalizer\XmlStringNormalizerInterface
     */
    public function createXmlStringNormalizer(): XmlStringNormalizerInterface
    {
        return new XmlStringNormalizer();
    }
}
