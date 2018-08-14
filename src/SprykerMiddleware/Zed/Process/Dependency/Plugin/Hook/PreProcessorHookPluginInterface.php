<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook;

use Generated\Shared\Transfer\ProcessResultTransfer;

interface PreProcessorHookPluginInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer|null $processResultTransfer
     *
     * @return void
     */
    public function process(?ProcessResultTransfer $processResultTransfer = null): void;
}
