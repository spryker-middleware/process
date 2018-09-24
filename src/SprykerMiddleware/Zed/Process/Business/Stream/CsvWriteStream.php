<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SplFileObject;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

class CsvWriteStream implements WriteStreamInterface
{
    /**
     * @var \SplFileObject
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
     * @var string
     */
    protected $delimiter;

    /**
     * @var string
     */
    protected $enclosure;

    /**
     * @var array
     */
    protected $header;

    /**
     * @param string $path
     * @param array $header
     * @param string $delimiter
     * @param string $enclosure
     */
    public function __construct(string $path, array $header = [], string $delimiter = ',', string $enclosure = '"')
    {
        $this->path = $path;
        $this->header = $header;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
    }

    /**
     * @inheritdoc
     */
    public function open(): bool
    {
        $this->handle = new SplFileObject($this->path, 'w');

        $this->data = [];

        $this->position = 0;

        $this->handle->fputcsv($this->header, $this->delimiter, $this->enclosure);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function close(): bool
    {
        if ($this->handle) {
            unset($this->handle);
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function write(array $data): int
    {
        $this->data[$this->position++] = $data;

        return 1;
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
    public function flush(): bool
    {
        foreach ($this->data as $item) {
            $this->handle->fputcsv($item, $this->delimiter, $this->enclosure);
        }
        $result = $this->handle->fflush();
        if ($result) {
            $this->data = [];
            $this->position = 0;
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function eof(): bool
    {
        return $this->position >= count($this->data);
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
