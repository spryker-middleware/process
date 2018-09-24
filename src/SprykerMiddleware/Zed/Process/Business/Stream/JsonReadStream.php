<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Exception\InvalidReadSourceException;

class JsonReadStream implements ReadStreamInterface
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

        $this->data = $this->loadJson();

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
            return $this->data[$this->position++];
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function seek(int $offset, int $whence): int
    {
        $newPosition = $this->getNewPosition($offset, $whence);
        if ($newPosition < 0 || $newPosition > count($this->data)) {
            return static::STATUS_SEEK_FAIL;
        }
        $this->position = $newPosition;

        return static::STATUS_SEEK_SUCCESS;
    }

    /**
     * @return bool
     */
    public function eof(): bool
    {
        return $this->position >= count($this->data);
    }

    /**
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\InvalidReadSourceException
     *
     * @return mixed
     */
    protected function loadJson()
    {
        $data = '';

        while (!feof($this->handle)) {
            $data .= fread($this->handle, 1000);
        }

        $this->position = 0;

        $json = json_decode($data, true);
        if ((json_last_error() !== JSON_ERROR_NONE)) {
            throw new InvalidReadSourceException("Invalid json: " . json_last_error_msg());
        }
        return $json;
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
     */
    protected function getNewPosition(int $offset, int $whence)
    {
        $newPosition = $this->position;
        if ($whence === SEEK_SET) {
            $newPosition = $offset;
        }

        if ($whence === SEEK_CUR) {
            $newPosition = $this->position + $offset;
        }

        if ($whence === SEEK_END) {
            $offset = $offset <= 0 ? $offset : 0;
            $newPosition = count($this->data) + $offset;
        }

        return $newPosition;
    }
}
