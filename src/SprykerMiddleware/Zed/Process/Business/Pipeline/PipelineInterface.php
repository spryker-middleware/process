<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Pipeline;

use Generated\Shared\Transfer\ProcessResultTransfer;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface PipelineInterface
{
    /**
     * @param callable $operation
     *
     * @return static
     */
    public function pipe(callable $operation);

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return mixed
     */
    public function process($payload, WriteStreamInterface $outStream, ProcessResultTransfer $processResultTransfer);

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return mixed
     */
    public function __invoke($payload, WriteStreamInterface $outStream, ProcessResultTransfer $processResultTransfer);
}
