<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Service\Process;

use Spryker\Service\Kernel\AbstractServiceFactory;
use SprykerMiddleware\Service\Process\Model\StreamService;
use SprykerMiddleware\Service\Process\Model\StreamServiceInterface;

class ProcessServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \SprykerMiddleware\Service\Process\Model\StreamServiceInterface
     */
    public function createStreamService(): StreamServiceInterface
    {
        return new StreamService();
    }
}
