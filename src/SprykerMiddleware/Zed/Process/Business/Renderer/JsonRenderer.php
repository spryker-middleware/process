<?php

namespace SprykerMiddleware\Zed\Process\Business\Renderer;

class JsonRenderer implements RendererInterface
{
    /**
     * @param mixed $data
     *
     * @return string
     */
    public function render($data)
    {
        return json_encode($data);
    }
}
