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
    protected $inputStream;

    /**
     * @var \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    protected $innerStream;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inputStream
     * @param \SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface $streamFactory
     */
    public function __construct(ReadStreamInterface $inputStream, StreamFactoryInterface $streamFactory)
    {
        $this->inputStream = $inputStream;
        $this->streamFactory = $streamFactory;
    }

    /**
     * @inheritdoc
     */
    public function current(): ReadStreamInterface
    {
        return $this->innerStream;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        if (!$this->innerStream->eof()) {
            return;
        }
        $this->initInnerStreamForNextItem();
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
        return !$this->inputStream->eof() || !$this->innerStream->eof();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->inputStream->seek(0, SEEK_SET);
        $this->innerStream = null;
        $this->initInnerStreamForNextItem();
    }

    /**
     * @return void
     */
    protected function initInnerStreamForNextItem()
    {
        if ($this->inputStream->eof()) {
            return;
        }
        do {
            $path = $this->inputStream->read();
            $this->innerStream = $this->streamFactory->createJsonStream($path);
            $this->innerStream->open('r');
            if (!$this->innerStream->eof()) {
                return;
            }
        } while (!$this->inputStream->eof());
    }
}
