<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Stream\XmlStringNormalizer\XmlStringNormalizerInterface;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapterInterface;
use XMLWriter;

class XmlWriteStream implements WriteStreamInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $rootNodeName;

    /**
     * @var string
     */
    private $entityNodeName;

    /**
     * @var string|null
     */
    private $version;

    /**
     * @var string|null
     */
    private $encoding;

    /**
     * @var string|null
     */
    private $standalone;

    /**
     * @var \XMLWriter
     */
    private $xmlWriter;

    /**
     * @var bool
     */
    protected $isEof;

    /**
     * @var string
     */
    protected $current;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapterInterface
     */
    private $encoder;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Stream\XmlStringNormalizer\XmlStringNormalizerInterface
     */
    private $xmlStringNormalizer;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var int
     */
    protected $position;

    /**
     * @param string $path
     * @param string $rootNodeName
     * @param string $entityNodeName
     * @param \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapterInterface $encoder
     * @param \SprykerMiddleware\Zed\Process\Business\Stream\XmlStringNormalizer\XmlStringNormalizerInterface $xmlStringNormalizer
     * @param string|null $version
     * @param string|null $encoding
     * @param string|null $standalone
     */
    public function __construct(
        string $path,
        string $rootNodeName,
        string $entityNodeName,
        ProcessToSymfonyEncoderAdapterInterface $encoder,
        XmlStringNormalizerInterface $xmlStringNormalizer,
        ?string $version = null,
        ?string $encoding = null,
        ?string $standalone = null
    ) {
        $this->path = $path;
        $this->rootNodeName = $rootNodeName;
        $this->entityNodeName = $entityNodeName;
        $this->version = $version;
        $this->encoding = $encoding;
        $this->standalone = $standalone;
        $this->encoder = $encoder;
        $this->xmlStringNormalizer = $xmlStringNormalizer;
    }

    /**
     * @inheritdoc
     */
    public function open(): bool
    {
        $this->initWriter();
        $this->xmlWriter->startDocument($this->version, $this->encoding, $this->standalone);
        $this->xmlWriter->startElement($this->rootNodeName);

        $this->data = [];

        $this->position = 0;

        return true;
    }

    /**
     * @inheritdoc
     */
    public function close(): bool
    {
        if ($this->xmlWriter) {
            $this->xmlWriter->endDocument();
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function write(array $data): int
    {
        $xmlString = $this->encoder->encode($data, 'xml', $this->getContext());
        $normalizedXmlString = $this->xmlStringNormalizer->normalizeXmlString($xmlString);
        return $this->xmlWriter->writeRaw($normalizedXmlString);
    }

    /**
     * @return bool
     */
    public function flush(): bool
    {
        return $this->xmlWriter->flush();
    }

    /**
     * @inheritdoc
     */
    public function seek(int $offset, int $whence): int
    {
        return -1;
    }

    /**
     * @return bool
     */
    public function eof(): bool
    {
        return $this->position >= count($this->data);
    }

    /**
     * @return array
     */
    protected function getContext(): array
    {
        return [
            'xml_root_node_name' => $this->entityNodeName,
        ];
    }

    /**
     * @return bool
     */
    protected function initWriter(): bool
    {
        $this->xmlWriter = new XMLWriter();
        touch($this->path);
        return $this->xmlWriter->openUri($this->path);
    }
}
