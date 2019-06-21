<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Stream;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class XmlInputStreamPlugin extends AbstractOptionAwareStreamPlugin implements InputStreamPluginInterface
{
    protected const PLUGIN_NAME = 'XmlInputStreamPlugin';

    protected const ROOT_NODE_NAME_STREAM_OPTION = 'rootNodeName';

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
                $this->options[static::ROOT_NODE_NAME_STREAM_OPTION],
                $this->getFactory()->getDecoder()
            );
    }

    protected function configureOptionsResolver(): OptionsResolver
    {
        return $this->createOptionsResolver()
            ->setRequired([static::ROOT_NODE_NAME_STREAM_OPTION])
            ->setAllowedTypes(static::ROOT_NODE_NAME_STREAM_OPTION, [static::OPTION_TYPE_STRING]);
    }
}
