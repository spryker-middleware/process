<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[] $stages
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
            $this->processResultHelper->increaseStageInputItemCount($processResultTransfer, get_class($stage->getStagePlugin()));
            $payload = call_user_func($stage, $payload, $outStream, $originalPayload);
            $this->processResultHelper->increaseStageOutputItemCount($processResultTransfer, get_class($stage->getStagePlugin()));
        }

        return $payload;
    }
}
