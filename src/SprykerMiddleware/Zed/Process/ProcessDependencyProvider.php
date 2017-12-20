<?php
namespace SprykerMiddleware\Zed\Process;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ProcessDependencyProvider extends AbstractBundleDependencyProvider
{
    const MIDDLEWARE_PROCESS_STAGES = 'MIDDLEWARE_PROCESS_STAGES';
    const MIDDLEWARE_PROCESS_ITERATORS = 'MIDDLEWARE_PROCESS_ITERATORS';
    const MIDDLEWARE_PROCESS_LOGGERS = 'MIDDLEWARE_PROCESS_LOGGERS';
    const MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK = 'MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK';
    const MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK = 'MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container[self::MIDDLEWARE_PROCESS_STAGES] = function () {
            return $this->registerProcessStages();
        };

        $container[self::MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK] = function () {
            return $this->registerPreProcessorHooks();
        };

        $container[self::MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK] = function () {
            return $this->registerPostProcessorHooks();
        };

        return $container;
    }

    /**
     * @return array
     */
    public function registerProcessorStages(): array
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
