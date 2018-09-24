<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

use SplFileObject;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

class CsvReadStream implements ReadStreamInterface
{
    /**
     * @var \SplFileObject
     */
    protected $file;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var int
     */
    protected $position;

    /**
     * @var string
     */
    private $delimiter;

    /**
     * @var string
     */
    private $enclosure;

    /**
     * @param string $path
     * @param string $delimiter
     * @param string $enclosure
     */
    public function __construct(string $path, string $delimiter = ',', string $enclosure = '"')
    {
        $this->path = $path;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
    }

    /**
     * @return mixed
     */
    public function read()
    {
        return $this->file->fgetcsv($this->delimiter, $this->enclosure);
    }

    /**
     * @return bool
     */
    public function open(): bool
    {
        $this->file = new SplFileObject($this->path);

        return true;
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        unset($this->file);

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
        if ($whence === SEEK_SET) {
            $this->file->seek($offset);

            return static::STATUS_SEEK_SUCCESS;
        }

        return $this->file->fseek($offset, $whence);
    }

    /**
     * @return bool
     */
    public function eof(): bool
    {
        return $this->file->eof();
    }
}
