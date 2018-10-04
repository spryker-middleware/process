<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapterInterface;
use XMLReader;

class XmlReadStream implements ReadStreamInterface
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
     * @var \XMLReader
     */
    protected $xmlReader;

    /**
     * @var bool
     */
    protected $isEof;

    /**
     * @var string
     */
    protected $current;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapterInterface
     */
    private $decoder;

    /**
     * @param string $path
     * @param string $rootNodeName
     * @param \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapterInterface $decoder
     */
    public function __construct(string $path, string $rootNodeName, ProcessToSymfonyDecoderAdapterInterface $decoder)
    {
        $this->path = $path;
        $this->rootNodeName = $rootNodeName;
        $this->decoder = $decoder;
    }

    /**
     * @return mixed
     */
    public function read()
    {
        $data = $this->current;
        $this->readNode();

        return $this->decoder->decode($data, 'xml');
    }

    /**
     * @return bool
     */
    public function open(): bool
    {
        $this->isEof = false;

        return $this->initReader();
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        return $this->xmlReader->close();
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
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
        return $this->isEof;
    }

    /**
     * @return void
     */
    protected function readNode(): void
    {
        while ($this->xmlReader->read()) {
            if ($this->xmlReader->nodeType === XMLReader::ELEMENT &&
                $this->xmlReader->name === $this->rootNodeName) {
                $this->current = $this->xmlReader->readOuterXml();
                $this->isEof = false;
                return;
            }
        }
        $this->isEof = true;
    }

    /**
     * @return bool
     */
    protected function initReader(): bool
    {
        $this->xmlReader = new XMLReader();

        $result = $this->xmlReader->open($this->path);
        if ($result) {
            $this->readNode();
        }

        return $result;
    }
}
