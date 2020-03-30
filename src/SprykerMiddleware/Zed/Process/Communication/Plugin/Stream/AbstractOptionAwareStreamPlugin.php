<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Stream;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator\StreamConfiguratorInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OptionAwareStreamPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
abstract class AbstractOptionAwareStreamPlugin extends AbstractPlugin implements OptionAwareStreamPluginInterface
{
    /**
     * @var array|null
     */
    protected $options;

    /**
     * @api
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $this->getStreamConfigurator()->resolveOptions($options);

        return $this;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator\StreamConfiguratorInterface
     */
    abstract protected function getStreamConfigurator(): StreamConfiguratorInterface;
}
