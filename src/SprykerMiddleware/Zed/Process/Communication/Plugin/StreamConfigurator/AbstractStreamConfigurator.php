<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator;

use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractStreamConfigurator implements StreamConfiguratorInterface
{
    protected const OPTION_TYPE_STRING = 'string';
    protected const OPTION_TYPE_NULL = 'null';

    /**
     * @var \Symfony\Component\OptionsResolver\OptionsResolver $optionsResolver
     */
    protected $optionsResolver;

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $optionsResolver
     */
    public function __construct(OptionsResolver $optionsResolver)
    {
        $this->optionsResolver = $optionsResolver;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function resolveOptions(array $options): array
    {
        return $this->configureOptionsResolver()->resolve($options);
    }

    /**
     * @return \Symfony\Component\OptionsResolver\OptionsResolver
     */
    abstract protected function configureOptionsResolver(): OptionsResolver;
}
