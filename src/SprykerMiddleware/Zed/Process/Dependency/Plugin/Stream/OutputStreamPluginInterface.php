<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream;

use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface OutputStreamPluginInterface
{
    /**
     * @api
     *
     * @return string
     */
    public function getName(): string;

    /**
     * @api
     *
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function getOutputStream(string $path): WriteStreamInterface;
}
