<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Service\Process\Model;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface StreamServiceInterface
{
    /**
     * Stream service interface.
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $stream
     *
     * @return mixed
     */
    public function read(ReadStreamInterface $stream);

    /**
     * Stream service interface.
     *
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $stream
     * @param mixed $data
     *
     * @return mixed
     */
    public function write(WriteStreamInterface $stream, $data);
}
