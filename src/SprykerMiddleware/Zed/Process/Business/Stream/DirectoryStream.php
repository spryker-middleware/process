<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use DirectoryIterator;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

class DirectoryStream implements ReadStreamInterface
{
    /**
     * @var \DirectoryIterator
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
     * @return mixed
     */
    public function get()
    {
        if (!$this->eof()) {
            return $this->list[$this->position++];
        }

        return false;
    }

    /**
     * @param string $mode
     *
     * @return bool
     */
    public function open(string $mode): bool
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
        return $this->get();
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
            return false;
        }
        $this->position = $newPosition;

        return true;
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
