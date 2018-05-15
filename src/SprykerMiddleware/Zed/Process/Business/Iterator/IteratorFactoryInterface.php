<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;

interface IteratorFactoryInterface
{
    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Iterator\IteratorInterface
     */
    public function createNullIterator(ReadStreamInterface $inStream): IteratorInterface;

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Iterator\IteratorInterface
     */
    public function createJsonDirectoryIterator(ReadStreamInterface $inStream): IteratorInterface;
}
