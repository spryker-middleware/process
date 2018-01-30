<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use Iterator;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

class IteratorFactory
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     *
     * @return \Iterator
     */
    public function createNullIterator(ReadStreamInterface $inStream): Iterator
    {
        return new NullIterator($inStream);
    }
}
