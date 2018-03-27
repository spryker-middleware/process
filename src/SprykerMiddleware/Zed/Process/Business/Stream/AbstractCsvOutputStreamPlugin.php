<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream;

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
    abstract public function getHeader(): array;

    /**
     * @return string
     */
    abstract public function getDelimiter(): string;

    /**
     * @return string
     */
    abstract public function getEnclosure(): string;
}
