<?php

namespace SprykerMiddleware\Zed\Process\Business\Renderer;

interface RendererInterface
{
    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function render($data);
}
