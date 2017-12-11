<?php
namespace SprykerMiddleware\Zed\Process;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ProcessDependencyProvider extends AbstractBundleDependencyProvider
{
    const MIDDLEWARE_PROCESS_STAGES = 'MIDDLEWARE_PROCESS_STAGES';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container[self::MIDDLEWARE_PROCESS_STAGES] = function () {
            return $this->registerProcessStages();
        };

        return $container;
    }

    /**
     * @return array
     */
    public function registerProcessStages()
    {
        return [];
    }
}
