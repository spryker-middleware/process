<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\External;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;

class ProcessToSymfonyDecoderAdapter implements ProcessToSymfonyDecoderAdapterInterface
{
    /**
     * @var \Symfony\Component\Serializer\Encoder\DecoderInterface
     */
    protected $decoder;

    public function __construct()
    {
        $this->decoder = new Serializer([], [new XmlEncoder()]);
    }

    /**
     * @param string $data
     * @param string $format
     *
     * @return array
     */
    public function decode(string $data, string $format): array
    {
        return $this->decoder
            ->decode($data, $format);
    }
}
