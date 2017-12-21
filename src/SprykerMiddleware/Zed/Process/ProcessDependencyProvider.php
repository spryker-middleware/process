<?php
namespace SprykerMiddleware\Zed\Process;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingBridge;

class ProcessDependencyProvider extends AbstractBundleDependencyProvider
{
    const MIDDLEWARE_PROCESSES = 'MIDDLEWARE_PROCESSES';
    const MIDDLEWARE_PIPELINES = 'MIDDLEWARE_PIPELINES';
    const MIDDLEWARE_PROCESS_ITERATORS = 'MIDDLEWARE_PROCESS_ITERATORS';
    const MIDDLEWARE_PROCESS_LOGGERS = 'MIDDLEWARE_PROCESS_LOGGERS';
    const MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK = 'MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK';
    const MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK = 'MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK';
    const SERVICE_UTIL_ENCODING = 'util encoding service';

    const PIPELINE = 'PIPELINE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container[self::MIDDLEWARE_PROCESSES] = function () {
            return $this->registerProcesses();
        };

        $container[self::MIDDLEWARE_PIPELINES] = function () {
            return $this->registerPipelines();
        };

        $container[self::MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK] = function () {
            return $this->registerPreProcessorHooks();
        };

        $container[self::MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK] = function () {
            return $this->registerPostProcessorHooks();
        };

        $container[self::SERVICE_UTIL_ENCODING] = function (Container $container) {
            return new ProcessToUtilEncodingBridge($container->getLocator()->utilEncoding()->service());
        };

        return $container;
    }

    /**
     * @return array
     */
    public function registerProcesses(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function registerPipelines(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function registerPreProcessorHooks(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function registerPostProcessHooks(): array
    {
        return [];
    }
}
