<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Stream;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapterInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
abstract class AbstractXmlInputStreamPlugin extends AbstractPlugin implements InputStreamPluginInterface
{
    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function getInputStream(string $path): ReadStreamInterface
    {
        return $this->getFactory()
            ->createStreamFactory()
            ->createXmlReadStream($path, $this->getRootNode(), $this->getDecoder());
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapterInterface
     */
    protected function getDecoder(): ProcessToSymfonyDecoderAdapterInterface
    {
        return $this->getFactory()
            ->getDecoder();
    }

    /**
     * @return string
     */
    abstract protected function getRootNode(): string;
}
