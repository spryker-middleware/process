<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
     * @return mixed
     */
    public function encode($data, string $format, array $context)
    {
        return $this->encoder
            ->encode($data, $format, $context);
    }
}
