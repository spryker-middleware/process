<?php

namespace SprykerMiddleware\Zed\Process\Business\Stream;

class JsonStream
{
    protected $subhandle;

    protected $data = [];

    protected $mode = '';

    protected $position;

    public function stream_close()
    {
        return fclose($this->subhandle);
    }

    public function stream_eof()
    {
///feof($this->subhandle) ||
        return $this->position >= count($this->data);
    }

    public function stream_flush()
    {
        fwrite($this->subhandle, json_encode($this->data));
        return fflush($this->subhandle);
    }

    /**
     * @return void
     */
    public function stream_write($data)
    {
        $this->data[] = $data;
    }

    public function stream_read()
    {
        if (!$this->stream_eof()) {
            return json_encode($this->data[$this->position++]) . PHP_EOL;
        }

        return false;
    }

    public function stream_stat()
    {
        return fstat($this->subhandle);
    }

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
