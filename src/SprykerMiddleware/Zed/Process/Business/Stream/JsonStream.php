<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\StreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

class JsonStream implements StreamInterface, WriteStreamInterface, ReadStreamInterface
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
     * @var string
     */
    protected $mode = '';

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
    public function open(string $mode): bool
    {
        $this->handle = fopen($this->path, $mode);

        if ($this->handle === false) {
            return false;
        }

        if (strpos($mode, 'r') !== false || strpos($mode, '+') !== false) {
            $this->data = $this->loadJson();
        }

        if (strpos($mode, 'a') !== false) {
            $this->position = count($this->data);
        }

        if (strpos($mode, 'w') !== false) {
            $this->position = 0;
        }

        $this->mode = $mode;

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
        return $this->get();
    }

    /**
     * @inheritdoc
     */
    public function get()
    {
        if (!$this->eof()) {
            return $this->data[$this->position++];
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

        return fflush($this->handle);
    }

    /**
     * @return bool
     */
    public function eof(): bool
    {
        return $this->position >= count($this->data);
    }

    /**
     * @return mixed
     */
    protected function loadJson()
    {
        $data = '';

        while (!feof($this->handle)) {
            $data .= fread($this->handle, 1000);
        }

        $this->position = 0;

        return json_decode($data, true);
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
