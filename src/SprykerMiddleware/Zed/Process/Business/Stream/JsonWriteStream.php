<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

class JsonWriteStream implements WriteStreamInterface
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
            return fclose($this->handle);
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function write($data): int
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
            return false;
        }
        $this->position = $newPosition;

        return true;
    }

    /**
     * @return bool
     */
    public function flush(): bool
    {
        fwrite($this->handle, json_encode($this->data));
        $result = fflush($this->handle);
        if ($result) {
            $data = [];
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
