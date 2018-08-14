<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
