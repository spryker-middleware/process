<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

class StreamFactory
{
    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface|\SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createJsonStream(string $path)
    {
        return new JsonStream($path);
    }
}
