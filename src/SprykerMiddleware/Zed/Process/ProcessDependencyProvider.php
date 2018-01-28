<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

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
    const MIDDLEWARE_DEFAULT_PROCESSES = 'MIDDLEWARE_DEFAULT_PROCESSES';
    const MIDDLEWARE_CONFIGURATION_PROFILES = 'MIDDLEWARE_CONFIGURATION_PROFILES';
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

        $container = $this->addDefaultProcessesStack($container);
        $container = $this->addDefaultLoggerConfigPlugin($container);
        $container = $this->addLogHandlers($container);
        $container = $this->addLogProcessors($container);
        $container = $this->addProcessService($container);

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
        $container = $this->addConfigurationProfilesStack($container);
        $container = $this->addProcessService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addConfigurationProfilesStack($container)
    {
        $container[static::MIDDLEWARE_CONFIGURATION_PROFILES] = function () {
            return $this->getConfigurationProfilePluginsStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addDefaultProcessesStack($container)
    {
        $container[static::MIDDLEWARE_DEFAULT_PROCESSES] = function () {
            return $this->getDefaultProcessesPluginsStack();
        };

        return $container;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    protected function getDefaultProcessesPluginsStack()
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[]
     */
    protected function getConfigurationProfilePluginsStack()
    {
        return [];
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
    protected function addDefaultLoggerConfigPlugin($container)
    {
        $container[static::MIDDLEWARE_DEFAULT_LOG_CONFIG_PLUGIN] = function () {
            return $this->getDefaultLoggerConfigPlugin();
        };

        return $container;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    protected function getDefaultLoggerConfigPlugin()
    {
        return new MiddlewareLoggerConfigPlugin();
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
}
