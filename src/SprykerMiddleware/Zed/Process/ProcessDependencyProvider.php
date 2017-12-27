<?php
namespace SprykerMiddleware\Zed\Process;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingServiceBridge;

class ProcessDependencyProvider extends AbstractBundleDependencyProvider
{
    const MIDDLEWARE_PROCESSES = 'MIDDLEWARE_PROCESSES';
    const MIDDLEWARE_PIPELINES = 'MIDDLEWARE_PIPELINES';
    const MIDDLEWARE_PROCESS_ITERATORS = 'MIDDLEWARE_PROCESS_ITERATORS';
    const MIDDLEWARE_PROCESS_LOGGERS = 'MIDDLEWARE_PROCESS_LOGGERS';
    const MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK = 'MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK';
    const MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK = 'MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK';
    const SERVICE_UTIL_ENCODING = 'UTIL_ENCODING_SERVICE';
    const SERVICE_PROCESS = 'PROCESS_SERVICE';

    const PIPELINE = 'PIPELINE';
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
        $container = $this->addPipelines($container);
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
    protected function addPipelines(Container $container): Container
    {
        $container[static::MIDDLEWARE_PIPELINES] = function () {
            return $this->getPipelines();
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
            return $this->getPreProcessorHooks();
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
            return $this->getPostProcessorHooks();
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
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[][]
     */
    public function getPipelines(): array
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[][]
     */
    public function getPreProcessorHooks(): array
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[][]
     */
    public function getPostProcessorHooks(): array
    {
        return [];
    }
}
