<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

class JsonRowReadStream implements ReadStreamInterface
{
    /**
     * @var resource|null
     */
    protected $handle;

    /**
     * @var string
     */
    protected $path;

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
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @inheritdoc
     */
    public function open(): bool
    {
        $this->handle = fopen($this->path, 'r');

        if ($this->handle === false) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function close(): bool
    {
        if ($this->handle) {
            return fclose($this->handle);
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function read()
    {
        if (!$this->eof()) {
            return json_decode(fgets($this->handle), true);
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function seek(int $offset, int $whence): int
    {
        return static::STATUS_SEEK_SUCCESS;
    }

    /**
     * @inheritdoc
     */
    public function eof(): bool
    {
        return feof($this->handle);
    }
}
