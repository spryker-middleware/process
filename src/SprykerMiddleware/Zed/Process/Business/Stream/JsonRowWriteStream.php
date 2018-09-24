<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

class JsonRowWriteStream implements WriteStreamInterface
{
    protected const KEY_SIZE = 'size';

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
     * @var int
     */
    protected $bufferSize;

    /**
     * @var int
     */
    protected $count;

    /**
     * @param string $path
     * @param int $bufferSize
     */
    public function __construct(string $path, $bufferSize = 200)
    {
        $this->path = $path;
        $this->bufferSize = $bufferSize;
        $this->count = 0;
        $this->position = 0;
    }

    /**
     * @inheritdoc
     */
    public function open(): bool
    {
        $this->handle = fopen($this->path, 'w');

        if ($this->handle === false) {
            return false;
        }

        $this->data = [];

        $this->position = 0;

        return true;
    }

    /**
     * @inheritdoc
     */
    public function close(): bool
    {
        if ($this->handle) {
            $this->flush();
            $stat = fstat($this->handle);
            ftruncate($this->handle, $stat[static::KEY_SIZE] - 1);

            return fclose($this->handle);
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function write(array $data): int
    {
        $this->data[$this->position++] = $data;
        $this->count++;

        if ($this->count > $this->bufferSize) {
            $this->flush();
        }

        return 1;
    }

    /**
     * @inheritdoc
     */
    public function seek(int $offset, int $whence): int
    {
        $newPosition = $this->getNewPosition($offset, $whence);
        if ($newPosition < 0 || $newPosition > count($this->data)) {
            return 0;
        }
        $this->position = $newPosition;

        return 1;
    }

    /**
     * @return bool
     */
    public function flush(): bool
    {
        foreach ($this->data as $element) {
            fwrite($this->handle, json_encode($element) . PHP_EOL);
        }

        $result = fflush($this->handle);
        if ($result) {
            $this->data = [];
            $this->position = 0;
            $this->count = 0;
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
