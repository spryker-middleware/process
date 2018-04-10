<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Stream;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
abstract class AbstractCsvOutputStreamPlugin extends AbstractPlugin implements OutputStreamPluginInterface
{
    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function getOutputStream(string $path): WriteStreamInterface
    {
        return $this->getFactory()
            ->createStreamFactory()
            ->createCsvWriteStream($path, $this->getHeader(), $this->getDelimiter(), $this->getEnclosure());
    }

    /**
     * @return array
     */
    abstract protected function getHeader(): array;

    /**
     * @return string
     */
    protected function getDelimiter(): string
    {
        return ",";
    }

    /**
     * @return string
     */
    protected function getEnclosure(): string
    {
        return '"';
    }
}
