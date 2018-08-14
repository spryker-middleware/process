<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\External;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;

class ProcessToSymfonyEncoderAdapter implements ProcessToSymfonyEncoderAdapterInterface
{
    /**
     * @var \Symfony\Component\Serializer\Encoder\EncoderInterface
     */
    protected $encoder;

    public function __construct()
    {
        $this->encoder = new Serializer([], [new XmlEncoder()]);
    }

    /**
     * @param mixed $data
     * @param string $format
     * @param array $context
     *
     * @return string
     */
    public function encode($data, string $format, array $context): string
    {
        return $this->encoder
            ->encode($data, $format, $context);
    }
}
