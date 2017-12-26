<?php

namespace SprykerMiddleware\Zed\Process\Business\Stream;

// @codingStandardsIgnoreFile
class JsonStream
{
    /**
     * @var resource
     */
    protected $subhandle;

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
        return fclose($this->subhandle);
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
        fwrite($this->subhandle, json_encode($this->data));
        return fflush($this->subhandle);
    }

    /**
     * @param string $data
     *
     * @return void
     */
    public function stream_write($data)
    {
        $this->data[] = json_decode($data);
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
        return fstat($this->subhandle);
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
        $parts = parse_url($path);
        if ($opened_path === null) {
            $this->subhandle = fopen($parts['host'] . ':' . $parts['path'], $mode, $options);
        } else {
            $this->subhandle = fopen($parts['host'] . ':' . $parts['path'], $mode, $options, $opened_path);
        }

        if (strpos($mode, 'r') !== false) {
            $this->data = $this->loadJson();
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
        fseek($this->subhandle, 0, SEEK_SET);
        $this->data = $this->loadJson();
        $result = fseek($this->subhandle, 0, $whence);
        return $result;
    }

    /**
     * @return mixed
     */
    protected function loadJson()
    {
        $data = '';

        while (!feof($this->subhandle)) {
            $data .= fread($this->subhandle, 1000);
        }

        $this->position = 0;

        return json_decode($data);
    }
}
