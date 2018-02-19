<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Processor;

use Spryker\Shared\Log\Dependency\Plugin\LogProcessorPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
class IntrospectionProcessorPlugin extends AbstractPlugin implements LogProcessorPluginInterface
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function __invoke(array $data): array
    {
        return $this->getFactory()->createIntrospectionProcessor()->__invoke($data);
    }
}
