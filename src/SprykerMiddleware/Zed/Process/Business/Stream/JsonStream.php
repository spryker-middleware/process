<?php

namespace SprykerMiddleware\Zed\Process\Business\Stream;

// @codingStandardsIgnoreFile
class JsonStream
{
    /**
     * @var resource
     */
    public $context;

    /**
     * @var resource
     */
    protected $subHandle;

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
     * @return bool
     */
    public function stream_close()
    {
        return fclose($this->subHandle);
    }

    /**
     * @return bool
     */
    public function stream_eof()
    {
        return $this->position >= count($this->data);
    }

    /**
     * @return bool
     */
    public function stream_flush()
    {
        fwrite($this->subHandle, json_encode($this->data));

        return fflush($this->subHandle);
    }

    /**
     * @param string $data
     *
     * @return int
     */
    public function stream_write($data)
    {
        $this->data[$this->position++] = json_decode($data, true);

        return strlen($data);
    }

    /**
     * @return bool|string
     */
    public function stream_read()
    {
        if (!$this->stream_eof()) {
            return json_encode($this->data[$this->position++]) . PHP_EOL;
        }

        return false;
    }

    /**
     * @return array
     */
    public function stream_stat()
    {
        return fstat($this->subHandle);
    }

    /**
     * @param string $path
     * @param string $mode
     * @param int $options
     * @param string $opened_path
     *
     * @return bool
     */
    public function stream_open($path, $mode, $options, &$opened_path)
    {
        $useIncludePath = $options & STREAM_USE_PATH;
        $parts = parse_url($path);

        $this->subHandle = fopen($parts['host'] . ':' . $parts['path'], $mode, $useIncludePath, $this->context);

        if ($this->subHandle === false) {
            return false;
        }

        if (strpos($mode, 'r') !== false || strpos($mode, '+') !== false) {
            $this->data = $this->loadJson();
        }

        if (strpos($mode,'a') !== false) {
            $this->position = count($this->data);
        }

        if (strpos($mode,'w') !== false) {
            $this->position = 0;
        }

        $this->mode = $mode;

        return true;
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
     */
    public function stream_seek($offset, $whence = SEEK_SET)
    {
        $newPosition =  $this->getNewPosition($offset, $whence);
        if ($newPosition === false || $newPosition < 0 || $newPosition > count($this->data)) {
            return false;
        }
        $this->position = $newPosition;

        return true;
    }

    /**
     * @return int
     */
    public function stream_tell()
    {
        return $this->position;
    }

    /**
     * @return mixed
     */
    protected function loadJson()
    {
        $data = '';

        while (!feof($this->subHandle)) {
            $data .= fread($this->subHandle, 1000);
        }

        $this->position = 0;

        return json_decode($data, true);
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return bool|int
     */
    protected function getNewPosition($offset, $whence)
    {
        $newPosition = false;
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
