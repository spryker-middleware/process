<?php

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

class JsonStream implements StreamInterface
{
    /**
     * @var resource
     */
    protected $handle;

    /**
     * @var string
     */
    protected $path;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @inheritdoc
     */
    public function open(string $mode): bool
    {
        $this->handle = fopen($this->path, $mode);
        if ($this->handle) {
            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function close(): bool
    {
        if ($this->handle) {
            return fclose($this->handle);
        }
    }

    /**
     * @inheritdoc
     */
    public function read($length)
    {
        if (!feof($this->handle)) {
            $data = [];
            while (($length > 0) && (!feof($this->handle))) {
                $data[] = $this->get();
                $length--;
            }
            return $data;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function get()
    {
        return fgets($this->handle);
    }

    /**
     * @inheritdoc
     */
    public function write($data): int
    {
        return fwrite($this->handle, $data);
    }

    /**
     * @inheritdoc
     */
    public function seek($offset, $whence): int
    {
        return fseek($this->handle, $offset, $whence);
    }

    /**
     * @return bool
     */
    public function flush(): bool
    {
        return fflush($this->handle);
    }

    /**
     * @return bool
     */
    public function eof(): bool
    {
        return feof($this->handle);
    }
}
