<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Pipeline;

use Generated\Shared\Transfer\ProcessResultTransfer;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\PipelineProcessorInterface;

class Pipeline implements PipelineInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[]
     */
    protected $stages = [];

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\PipelineProcessorInterface
     */
    protected $pipelineProcessor;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\PipelineProcessorInterface $pipelineProcessor
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[] $stages
     */
    public function __construct(
        PipelineProcessorInterface $pipelineProcessor,
        array $stages
    ) {
        $this->pipelineProcessor = $pipelineProcessor;
        $this->stages = $stages;
    }

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface|callable $stage
     *
     * @return static
     */
    public function pipe(callable $stage)
    {
        $pipeline = clone $this;
        $pipeline->stages[] = $stage;

        return $pipeline;
    }

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return mixed
     */
    public function process($payload, WriteStreamInterface $outStream, ProcessResultTransfer $processResultTransfer)
    {
        return $this->pipelineProcessor->process($this->stages, $payload, $outStream, $processResultTransfer);
    }

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return mixed
     */
    public function __invoke($payload, WriteStreamInterface $outStream, ProcessResultTransfer $processResultTransfer)
    {
        return $this->process($payload, $outStream, $processResultTransfer);
    }
}
