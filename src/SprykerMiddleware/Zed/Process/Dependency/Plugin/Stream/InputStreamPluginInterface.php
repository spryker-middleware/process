<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

interface InputStreamPluginInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function getInputStream(string $path): ReadStreamInterface;
}
