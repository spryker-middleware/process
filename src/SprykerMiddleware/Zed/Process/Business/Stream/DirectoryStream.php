<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use DirectoryIterator;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

class DirectoryStream implements ReadStreamInterface
{
    /**
     * @var \DirectoryIterator|null
     */
    protected $directoryIterator;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string[]
     */
    protected $list;

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
     * @return bool
     */
    public function open(): bool
    {
        if (is_dir($this->path)) {
            $this->position = 0;
            return $this->prepareFileList();
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function read()
    {
        if (!$this->eof()) {
            return $this->list[$this->position++];
        }

        return false;
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        return true;
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
     */
    public function seek(int $offset, int $whence): int
    {
        $newPosition = $this->getNewPosition($offset, $whence);
        if ($newPosition < 0 || $newPosition > count($this->list)) {
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
        return $this->position >= count($this->list);
    }

    /**
     * @return bool
     */
    protected function prepareFileList()
    {
        $this->directoryIterator = new DirectoryIterator($this->path);
        foreach ($this->directoryIterator as $item) {
            if ($item->isFile()) {
                $this->list[] = $item->getPathname();
            }
        }
        return true;
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
            $newPosition = count($this->list) + $offset;
        }

        return $newPosition;
    }
}
