<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

class JsonRowReadStream implements ReadStreamInterface
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
        return true;
    }

    /**
     * @inheritdoc
     */
    public function eof(): bool
    {
        return feof($this->handle);
    }
}
