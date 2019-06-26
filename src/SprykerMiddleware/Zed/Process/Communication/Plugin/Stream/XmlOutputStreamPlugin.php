<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Stream;

use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator\StreamConfiguratorInterface;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator\XmlOutputStreamConfigurator;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class XmlOutputStreamPlugin extends AbstractOptionAwareStreamPlugin implements OutputStreamPluginInterface
{
    protected const PLUGIN_NAME = 'XmlOutputStreamPlugin';

    /**
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }

    /**
     * @api
     *
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function getOutputStream(string $path): WriteStreamInterface
    {
        return $this->getFactory()
            ->createStreamFactory()
            ->createXmlWriteStream(
                $path,
                $this->options[XmlOutputStreamConfigurator::ROOT_NODE_NAME_STREAM_OPTION],
                $this->options[XmlOutputStreamConfigurator::ENTITY_NODE_NAME_STREAM_OPTION],
                $this->getFactory()->getEncoder(),
                $this->options[XmlOutputStreamConfigurator::VERSION_STREAM_OPTION],
                $this->options[XmlOutputStreamConfigurator::ENCODING_STREAM_OPTION],
                $this->options[XmlOutputStreamConfigurator::STANDALONE_STREAM_OPTION]
            );
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator\StreamConfiguratorInterface
     */
    protected function getStreamConfigurator(): StreamConfiguratorInterface
    {
        return $this->getFactory()->createXmlOutputStreamConfigurator();
    }
}
