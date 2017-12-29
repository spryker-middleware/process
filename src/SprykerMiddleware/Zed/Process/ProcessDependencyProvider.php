<?php
namespace SprykerMiddleware\Zed\Process;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingServiceBridge;

class ProcessDependencyProvider extends AbstractBundleDependencyProvider
{
    const MIDDLEWARE_PROCESSES = 'MIDDLEWARE_PROCESSES';
    const MIDDLEWARE_STAGE_PLUGINS = 'MIDDLEWARE_STAGE_PLUGINS';
    const MIDDLEWARE_PROCESS_ITERATORS = 'MIDDLEWARE_PROCESS_ITERATORS';
    const MIDDLEWARE_PROCESS_LOGGERS = 'MIDDLEWARE_PROCESS_LOGGERS';
    const MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK = 'MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK';
    const MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK = 'MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK';
    const SERVICE_UTIL_ENCODING = 'UTIL_ENCODING_SERVICE';
    const SERVICE_PROCESS = 'PROCESS_SERVICE';

    const ITERATOR = 'ITERATOR';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addProcesses($container);
        $container = $this->addIterators($container);
        $container = $this->addStagePluginsStack($container);
        $container = $this->addPreProcessorHooks($container);
        $container = $this->addPostProcessorHooks($container);
        $container = $this->addServices($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProcesses(Container $container): Container
    {
        $container[static::MIDDLEWARE_PROCESSES] = function () {
            return $this->getProcesses();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addIterators($container)
    {
        $container[static::MIDDLEWARE_PROCESS_ITERATORS] = function () {
            return $this->getIteratorsStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStagePluginsStack(Container $container): Container
    {
        $container[static::MIDDLEWARE_STAGE_PLUGINS] = function () {
            return $this->getStagePluginsStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPreProcessorHooks(Container $container): Container
    {
        $container[static::MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK] = function () {
            return $this->getPreProcessorHooksStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPostProcessorHooks(Container $container): Container
    {
        $container[static::MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK] = function () {
            return $this->getPostProcessorHooksStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addServices(Container $container): Container
    {
        $container[static::SERVICE_UTIL_ENCODING] = function (Container $container) {
            return new ProcessToUtilEncodingServiceBridge($container->getLocator()->utilEncoding()->service());
        };

        $container[static::SERVICE_PROCESS] = function (Container $container) {
            return $container->getLocator()->process()->service();
        };

        return $container;
    }

    /**
     * @return array
     */
    public function getProcesses(): array
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[][]
     */
    public function getPreProcessorHooksStack(): array
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[][]
     */
    public function getPostProcessorHooksStack(): array
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[]
     */
    public function getStagePluginsStack()
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface[]
     */
    public function getIteratorsStack()
    {
        return [];
    }
}
