<?php

namespace SprykerMiddleware\Zed\Process\Business\Renderer;

use SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingInterface;

class JsonRenderer implements RendererInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingInterface
     */
    protected $utilEncoding;

    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingInterface $utilEncoding
     */
    public function __construct(ProcessToUtilEncodingInterface $utilEncoding)
    {
        $this->utilEncoding = $utilEncoding;
    }

    /**
     * @param mixed $data
     *
     * @return string
     */
    public function render($data)
    {
        return $this->utilEncoding->encodeJson($data);
    }
}
