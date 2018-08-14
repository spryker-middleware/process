<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Processor;

use Generated\Shared\Transfer\ProcessResultTransfer;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface PipelineProcessorInterface
{
    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[] $stages
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return mixed
     */
    public function process(array $stages, $payload, WriteStreamInterface $outStream, ProcessResultTransfer $processResultTransfer);
}
