<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator;

use Symfony\Component\OptionsResolver\OptionsResolver;

class XmlOutputStreamConfigurator extends AbstractStreamConfigurator
{
    public const ROOT_NODE_NAME_STREAM_OPTION = 'rootNodeName';
    public const ENTITY_NODE_NAME_STREAM_OPTION = 'entityNodeName';
    public const VERSION_STREAM_OPTION = 'version';
    public const ENCODING_STREAM_OPTION = 'encoding';
    public const STANDALONE_STREAM_OPTION = 'standalone';

    /**
     * @return \Symfony\Component\OptionsResolver\OptionsResolver
     */
    protected function configureOptionsResolver(): OptionsResolver
    {
        return $this->optionsResolver
            ->setDefaults([
                static::VERSION_STREAM_OPTION => null,
                static::ENCODING_STREAM_OPTION => null,
                static::STANDALONE_STREAM_OPTION => null,
            ])
            ->setRequired([
                static::ROOT_NODE_NAME_STREAM_OPTION,
                static::ENTITY_NODE_NAME_STREAM_OPTION,
            ])
            ->setAllowedTypes(
                static::ROOT_NODE_NAME_STREAM_OPTION,
                [
                    static::OPTION_TYPE_STRING, static::OPTION_TYPE_NULL,
                ]
            )
            ->setAllowedTypes(
                static::ENTITY_NODE_NAME_STREAM_OPTION,
                [
                    static::OPTION_TYPE_STRING, static::OPTION_TYPE_NULL,
                ]
            )
            ->setAllowedTypes(
                static::VERSION_STREAM_OPTION,
                [
                    static::OPTION_TYPE_STRING, static::OPTION_TYPE_NULL,
                ]
            )
            ->setAllowedTypes(
                static::ENCODING_STREAM_OPTION,
                [
                    static::OPTION_TYPE_STRING, static::OPTION_TYPE_NULL,
                ]
            )
            ->setAllowedTypes(
                static::STANDALONE_STREAM_OPTION,
                [
                    static::OPTION_TYPE_STRING, static::OPTION_TYPE_NULL,
                ]
            );
    }
}
