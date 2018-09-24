<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Processor;

use Generated\Shared\Transfer\ProcessResultTransfer;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelperInterface;

class FingersCrossedProcessor implements PipelineProcessorInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelperInterface
     */
    protected $processResultHelper;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelperInterface $processResultHelper
     */
    public function __construct(ProcessResultHelperInterface $processResultHelper)
    {
        $this->processResultHelper = $processResultHelper;
    }

    /**
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[] $stages
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return mixed
     */
    public function process(array $stages, $payload, WriteStreamInterface $outStream, ProcessResultTransfer $processResultTransfer)
    {
        $originalPayload = $payload;
        foreach ($stages as $stage) {
            $this->processResultHelper->increaseStageInputItemCount($processResultTransfer, $stage->getName());
            $startTime = round(microtime(true) * 1000);
            $payload = $stage->process($payload, $outStream, $originalPayload);
            $endTime = round(microtime(true) * 1000);
            $this->processResultHelper->increaseStageItemExecutionTime($processResultTransfer, $stage->getName(), $endTime - $startTime);
            $this->processResultHelper->increaseStageOutputItemCount($processResultTransfer, $stage->getName());
        }

        return $payload;
    }
}
