<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\External;

interface ProcessToSymfonyDecoderAdapterInterface
{
    /**
     * @param string $data
     * @param string $format
     *
     * @return array
     */
    public function decode(string $data, string $format): array;
}
