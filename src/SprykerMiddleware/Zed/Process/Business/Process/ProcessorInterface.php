<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Process;

interface ProcessorInterface
{
    /**
     * @return void
     */
    public function process(): void;
}
