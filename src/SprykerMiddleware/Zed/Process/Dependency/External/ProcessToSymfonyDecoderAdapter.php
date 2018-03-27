<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
