<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Stream;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator\StreamConfiguratorInterface;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator\XmlInputStreamConfigurator;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class XmlInputStreamPlugin extends AbstractOptionAwareStreamPlugin implements InputStreamPluginInterface
{
    protected const PLUGIN_NAME = 'XmlInputStreamPlugin';

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
     * @return \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    public function getInputStream(string $path): ReadStreamInterface
    {
        return $this->getFactory()
            ->createStreamFactory()
            ->createXmlReadStream(
                $path,
                $this->options[XmlInputStreamConfigurator::ROOT_NODE_NAME_STREAM_OPTION],
                $this->getFactory()->getDecoder()
            );
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator\StreamConfiguratorInterface
     */
    protected function getStreamConfigurator(): StreamConfiguratorInterface
    {
        return $this->getFactory()->createXmlInputStreamConfigurator();
    }
}
