<?php
namespace SprykerMiddleware\Zed\Process;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Log\Communication\Plugin\Processor\PsrLogMessageProcessorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Handler\StdErrStreamHandlerPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Log\MiddlewareLoggerConfigPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Processor\IntrospectionProcessorPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingServiceBridge;

class ProcessDependencyProvider extends AbstractBundleDependencyProvider
{
    const MIDDLEWARE_PROCESSES = 'MIDDLEWARE_PROCESSES';
    const MIDDLEWARE_STAGE_PLUGINS = 'MIDDLEWARE_STAGE_PLUGINS';
    const MIDDLEWARE_PROCESS_ITERATORS = 'MIDDLEWARE_PROCESS_ITERATORS';
    const MIDDLEWARE_PROCESS_LOGGERS = 'MIDDLEWARE_PROCESS_LOGGERS';
    const MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK = 'MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK';
    const MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK = 'MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK';
    const MIDDLEWARE_LOG_CONFIGS = 'MIDDLEWARE_LOG_CONFIGS';
    const MIDDLEWARE_LOG_HANDLERS = 'MIDDLEWARE_LOG_HANDLERS';
    const MIDDLEWARE_LOG_PROCESSORS = 'MIDDLEWARE_LOG_PROCESSORS';
    const MIDDLEWARE_DEFAULT_LOG_CONFIG_PLUGIN = 'MIDDLEWARE_DEFAULT_LOG_CONFIG_PLUGIN';
    const SERVICE_UTIL_ENCODING = 'UTIL_ENCODING_SERVICE';

    const SERVICE_PROCESS = 'PROCESS_SERVICE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addLogHandlers($container);
        $container = $this->addLogProcessors($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addIterators($container);
        $container = $this->addStagePluginsStack($container);
        $container = $this->addPreProcessorHooks($container);
        $container = $this->addPostProcessorHooks($container);
        $container = $this->addEncodingService($container);
        $container = $this->addProcessService($container);
        $container = $this->addLogConfigPlugins($container);
        $container = $this->addDefaultLoggerConfigPlugin($container);

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
    protected function addEncodingService(Container $container): Container
    {
        $container[static::SERVICE_UTIL_ENCODING] = function (Container $container) {
            return new ProcessToUtilEncodingServiceBridge($container->getLocator()->utilEncoding()->service());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProcessService(Container $container): Container
    {
        $container[static::SERVICE_PROCESS] = function (Container $container) {
            return $container->getLocator()->process()->service();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLogHandlers($container)
    {
        $container[static::MIDDLEWARE_LOG_HANDLERS] = function () {
            return $this->getLogHandlers();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLogProcessors($container)
    {
        $container[static::MIDDLEWARE_LOG_PROCESSORS] = function () {
            return $this->getLogProcessors();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLogConfigPlugins($container)
    {
        $container[static::MIDDLEWARE_LOG_CONFIGS] = function () {
            return $this->getLoggerConfigPluginsStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addDefaultLoggerConfigPlugin($container)
    {
        $container[static::MIDDLEWARE_DEFAULT_LOG_CONFIG_PLUGIN] = function () {
            return $this->getDefaultLoggerConfigPlugin();
        };

        return $container;
    }

    /**
     * @return array
     */
    protected function getProcesses(): array
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[][]
     */
    protected function getPreProcessorHooksStack(): array
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[][]
     */
    protected function getPostProcessorHooksStack(): array
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[]
     */
    protected function getStagePluginsStack()
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface[]
     */
    protected function getIteratorsStack()
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface[]
     */
    protected function getLoggerConfigPluginsStack()
    {
        return [];
    }

    /**
     * @return \Spryker\Shared\Log\Dependency\Plugin\LogHandlerPluginInterface[]
     */
    protected function getLogProcessors()
    {
        return [
            new PsrLogMessageProcessorPlugin(),
            new IntrospectionProcessorPlugin(),
        ];
    }

    /**
     * @return \Spryker\Shared\Log\Dependency\Plugin\LogProcessorPluginInterface[]
     */
    protected function getLogHandlers()
    {
        return [
            new StdErrStreamHandlerPlugin(),
        ];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    protected function getDefaultLoggerConfigPlugin()
    {
        return new MiddlewareLoggerConfigPlugin();
    }
}
