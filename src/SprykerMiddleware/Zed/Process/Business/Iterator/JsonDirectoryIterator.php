<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException;
use SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface;

class JsonDirectoryIterator implements IteratorInterface
{
    /**
     * @var \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    protected $directoryStream;

    /**
     * @var \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    protected $jsonStream;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $directoryStream
     * @param \SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface $streamFactory
     */
    public function __construct(ReadStreamInterface $directoryStream, StreamFactoryInterface $streamFactory)
    {
        $this->directoryStream = $directoryStream;
        $this->streamFactory = $streamFactory;
    }

    /**
     * @inheritdoc
     */
    public function current(): ReadStreamInterface
    {
        return $this->jsonStream;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        if (!$this->jsonStream->eof()) {
            return;
        }
        $this->initJsonStreamForNextItem();
    }

    /**
     * @inheritdoc
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException
     */
    public function key()
    {
        throw new MethodNotSupportedException(
            sprintf(
                "Method '%s' is not supported in class %s",
                'key',
                static::class
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return !$this->directoryStream->eof() || !$this->jsonStream->eof();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->directoryStream->seek(0, SEEK_SET);
        $this->initJsonStreamForNextItem();
    }

    /**
     * @return void
     */
    protected function initJsonStreamForNextItem()
    {
        if ($this->directoryStream->eof()) {
            return;
        }
        do {
            $path = $this->directoryStream->read();
            $this->jsonStream = $this->streamFactory->createJsonReadStream($path);
            $this->jsonStream->open();
            if (!$this->jsonStream->eof()) {
                return;
            }
        } while (!$this->directoryStream->eof());
    }
}
