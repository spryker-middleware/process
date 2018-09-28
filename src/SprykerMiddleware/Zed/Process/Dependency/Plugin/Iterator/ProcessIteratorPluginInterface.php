<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator;

use Generated\Shared\Transfer\IteratorConfigTransfer;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Iterator\IteratorInterface;

interface ProcessIteratorPluginInterface
{
    /**
     * @api
     *
     * @return string
     */
    public function getName(): string;

    /**
     * @api
     *
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inputStream
     * @param \Generated\Shared\Transfer\IteratorConfigTransfer $iteratorConfigTransfer
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Iterator\IteratorInterface
     */
    public function getIterator(ReadStreamInterface $inputStream, IteratorConfigTransfer $iteratorConfigTransfer): IteratorInterface;
}
