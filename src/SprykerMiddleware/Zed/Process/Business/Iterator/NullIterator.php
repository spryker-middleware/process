<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use Iterator;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException;

class NullIterator implements Iterator
{
    /**
     * @var \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    protected $inStream;

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     */
    public function __construct(ReadStreamInterface $inStream)
    {
        $this->inStream = $inStream;
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->inStream;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        return $this->inStream;
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
        return !$this->inStream->eof();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->inStream->seek(0, SEEK_SET);
    }
}
