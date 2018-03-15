<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException;

class NullIterator implements IteratorInterface
{
    /**
     * @var \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    protected $inputStream;

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inputStream
     */
    public function __construct(ReadStreamInterface $inputStream)
    {
        $this->inputStream = $inputStream;
    }

    /**
     * @inheritdoc
     */
    public function current(): ReadStreamInterface
    {
        return $this->inputStream;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        return $this->inputStream;
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
        return !$this->inputStream->eof();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->inputStream->seek(0, SEEK_SET);
    }
}
