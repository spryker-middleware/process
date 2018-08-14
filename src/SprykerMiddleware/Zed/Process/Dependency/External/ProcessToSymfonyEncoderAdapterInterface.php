<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\External;

interface ProcessToSymfonyEncoderAdapterInterface
{
    /**
     * @param mixed $data
     * @param string $format
     * @param array $context
     *
     * @return string
     */
    public function encode($data, string $format, array $context): string;
}
