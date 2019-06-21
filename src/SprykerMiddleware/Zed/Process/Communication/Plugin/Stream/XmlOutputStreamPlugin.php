<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Stream;

use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class XmlOutputStreamPlugin extends AbstractOptionAwareStreamPlugin implements OutputStreamPluginInterface
{
    protected const PLUGIN_NAME = 'XmlOutputStreamPlugin';

    protected const ROOT_NODE_NAME_STREAM_OPTION = 'rootNodeName';
    protected const ENTITY_NODE_NAME_STREAM_OPTION = 'entityNodeName';
    protected const VERSION_STREAM_OPTION = 'version';
    protected const ENCODING_STREAM_OPTION = 'encoding';
    protected const STANDALONE_STREAM_OPTION = 'standalone';

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
                $this->options[static::ROOT_NODE_NAME_STREAM_OPTION],
                $this->options[static::ENTITY_NODE_NAME_STREAM_OPTION],
                $this->getFactory()->getEncoder(),
                $this->options[static::VERSION_STREAM_OPTION],
                $this->options[static::ENCODING_STREAM_OPTION],
                $this->options[static::STANDALONE_STREAM_OPTION]
            );
    }

    protected function configureOptionsResolver(): OptionsResolver
    {
        return $this->createOptionsResolver()
            ->setDefaults([
                static::VERSION_STREAM_OPTION => null,
                static::ENCODING_STREAM_OPTION => null,
                static::STANDALONE_STREAM_OPTION => null,
            ])
            ->setRequired([static::ROOT_NODE_NAME_STREAM_OPTION, static::ENTITY_NODE_NAME_STREAM_OPTION])
            ->setAllowedTypes(
                static::ROOT_NODE_NAME_STREAM_OPTION, [
                    static::OPTION_TYPE_STRING, static::OPTION_TYPE_NULL
            ])
            ->setAllowedTypes(
            static::ENTITY_NODE_NAME_STREAM_OPTION, [
                static::OPTION_TYPE_STRING, static::OPTION_TYPE_NULL
            ])
            ->setAllowedTypes(
                static::VERSION_STREAM_OPTION, [
                static::OPTION_TYPE_STRING, static::OPTION_TYPE_NULL
            ])
            ->setAllowedTypes(
                static::ENCODING_STREAM_OPTION, [
                static::OPTION_TYPE_STRING, static::OPTION_TYPE_NULL
            ])
            ->setAllowedTypes(
                static::STANDALONE_STREAM_OPTION, [
                static::OPTION_TYPE_STRING, static::OPTION_TYPE_NULL
            ]);
    }
}
