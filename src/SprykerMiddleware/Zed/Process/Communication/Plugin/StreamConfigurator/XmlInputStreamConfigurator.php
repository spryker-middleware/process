<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator;

use Symfony\Component\OptionsResolver\OptionsResolver;

class XmlInputStreamConfigurator extends AbstractStreamConfigurator
{
    public const ROOT_NODE_NAME_STREAM_OPTION = 'rootNodeName';

    /**
     * @return \Symfony\Component\OptionsResolver\OptionsResolver
     */
    protected function configureOptionsResolver(): OptionsResolver
    {
        return $this->optionsResolver
            ->setRequired([static::ROOT_NODE_NAME_STREAM_OPTION])
            ->setAllowedTypes(static::ROOT_NODE_NAME_STREAM_OPTION, [static::OPTION_TYPE_STRING]);
    }
}
