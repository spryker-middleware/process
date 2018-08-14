<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
