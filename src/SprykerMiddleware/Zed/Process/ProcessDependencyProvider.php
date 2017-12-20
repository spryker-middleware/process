<?php
namespace SprykerMiddleware\Zed\Process;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingBridge;

class ProcessDependencyProvider extends AbstractBundleDependencyProvider
{
    const MIDDLEWARE_PROCESS_STAGES = 'MIDDLEWARE_PROCESS_STAGES';
    const SERVICE_UTIL_ENCODING = 'util encoding service';

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

        $container[self::SERVICE_UTIL_ENCODING] = function (Container $container) {
            return new ProcessToUtilEncodingBridge($container->getLocator()->utilEncoding()->service());
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
