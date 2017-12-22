<?php

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use Exception;
use Iterator;

class NullIterator implements Iterator
{
    /**
     * @var resource
     */
    protected $inStream;

    /**
     * @param resource $inStream
     */
    public function __construct($inStream)
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
        return !feof($this->inStream);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
    }
}
