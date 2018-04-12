<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Stream;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapterInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
abstract class AbstractXmlOutputStreamPlugin extends AbstractPlugin implements OutputStreamPluginInterface
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
            ->createXmlWriteStream($path, $this->getRootNode(), $this->getEntityNode(), $this->getVersion(), $this->getEncoding(), $this->getStandalone(), $this->getEncoder());
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapterInterface
     */
    protected function getEncoder(): ProcessToSymfonyEncoderAdapterInterface
    {
        return $this->getFactory()
            ->getEncoder();
    }

    /**
     * @return string
     */
    abstract protected function getRootNode(): string;

    /**
     * @return string
     */
    abstract protected function getEntityNode(): string;

    /**
     * @return string
     */
    protected function getVersion(): string
    {
        return '1.0';
    }

    /**
     * @return string
     */
    protected function getEncoding(): string
    {
        return 'utf-8';
    }

    /**
     * @return string
     */
    protected function getStandalone(): string
    {
        return 'yes';
    }
}
