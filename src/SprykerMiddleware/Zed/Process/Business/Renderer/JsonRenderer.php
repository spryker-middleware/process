<?php

namespace SprykerMiddleware\Zed\Process\Business\Renderer;

use SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingServiceInterface;

class JsonRenderer implements RendererInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingServiceInterface
     */
    protected $utilEncoding;

    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingServiceInterface $utilEncoding
     */
    public function __construct(ProcessToUtilEncodingServiceInterface $utilEncoding)
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