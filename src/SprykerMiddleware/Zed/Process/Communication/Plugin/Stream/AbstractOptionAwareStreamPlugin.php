<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Stream;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OptionAwareStreamPluginInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
abstract class AbstractOptionAwareStreamPlugin extends AbstractPlugin implements OptionAwareStreamPluginInterface
{
    protected const OPTION_TYPE_STRING = 'string';
    protected const OPTION_TYPE_NULL = 'null';

    /**
     * @var array
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
        $this->options = $this->configureOptionsResolver()->resolve($options);

        return $this;
    }

    /**
     * @return \Symfony\Component\OptionsResolver\OptionsResolver
     */
    protected function createOptionsResolver(): OptionsResolver
    {
        return new OptionsResolver();
    }

    /**
     * @return \Symfony\Component\OptionsResolver\OptionsResolver
     */
    abstract protected function configureOptionsResolver(): OptionsResolver;
}
