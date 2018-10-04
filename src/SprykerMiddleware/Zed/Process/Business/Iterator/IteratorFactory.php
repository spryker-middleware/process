<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Iterator;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface;

/**
 * @SuppressWarnings(FactoryOnlyGetAndCreateRule)
 */
class IteratorFactory implements IteratorFactoryInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface
     */
    protected $streamFactory;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface $streamFactory
     */
    public function __construct(StreamFactoryInterface $streamFactory)
    {
        $this->streamFactory = $streamFactory;
    }

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inputStream
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Iterator\IteratorInterface
     */
    public function createNullIterator(ReadStreamInterface $inputStream): IteratorInterface
    {
        return new NullIterator($inputStream);
    }

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inputStream
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Iterator\IteratorInterface
     */
    public function createJsonDirectoryIterator(ReadStreamInterface $inputStream): IteratorInterface
    {
        return new JsonDirectoryIterator($inputStream, $this->streamFactory);
    }
}
