<?php

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use Exception;
use Iterator;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

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
     * @throws \Exception
     */
    public function key()
    {
        throw  new Exception('not supported');
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
