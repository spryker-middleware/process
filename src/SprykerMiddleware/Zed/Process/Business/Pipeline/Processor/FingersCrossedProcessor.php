<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Pipeline\Processor;

use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

class FingersCrossedProcessor implements PipelineProcessorInterface
{
    /**
     * @param array $stages
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     *
     * @return mixed
     */
    public function process(array $stages, $payload, WriteStreamInterface $outStream)
    {
        $originalPayload = $payload;
        foreach ($stages as $stage) {
            $payload = call_user_func($stage, $payload, $outStream, $originalPayload);
        }

        return $payload;
    }
}
