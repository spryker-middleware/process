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
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\ArrayToStringTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\BoolToStringTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\DateTimeToStringTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\EnumTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\ExcludeKeysAssociativeFilterTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\ExcludeValuesAssociativeFilterTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\ExcludeValuesSequentalFilterTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\FloatToIntTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\FloatToStringTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\IntToFloatTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\IntToStringTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\MoneyDecimalToIntegerTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\MoneyIntegerToDecimalTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\StringToArrayTranslatoFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\StringToBoolTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\StringToDateTimeTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\StringToFloatTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\StringToIntTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\TranslatorFunction\WhitelistKeysAssociativeFilterTranslatorFunctionPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\DateTimeValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\EqualToValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\GreaterOrEqualThanValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\GreaterThanValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\InListValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\LengthValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\LessOrEqualThanValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\LessThanValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\NotBlankValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\NotEqualToValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\RegexValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\RequiredValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\TypeValidatorPlugin;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapter;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingServiceBridge;

class ProcessDependencyProvider extends AbstractBundleDependencyProvider
{
    const MIDDLEWARE_DEFAULT_PROCESSES = 'MIDDLEWARE_DEFAULT_PROCESSES';
    const MIDDLEWARE_CONFIGURATION_PROFILES = 'MIDDLEWARE_CONFIGURATION_PROFILES';
    const MIDDLEWARE_LOG_HANDLERS = 'MIDDLEWARE_LOG_HANDLERS';
    const MIDDLEWARE_LOG_PROCESSORS = 'MIDDLEWARE_LOG_PROCESSORS';
    const MIDDLEWARE_DEFAULT_LOG_CONFIG_PLUGIN = 'MIDDLEWARE_DEFAULT_LOG_CONFIG_PLUGIN';
    const MIDDLEWARE_GENERIC_TRANSLATOR_FUNCTIONS = 'MIDDLEWARE_GENERIC_TRANSLATOR_FUNCTIONS';
    const MIDDLEWARE_GENERIC_VALIDATORS = 'MIDDLEWARE_GENERIC_VALIDATORS';

    const SERVICE_UTIL_ENCODING = 'UTIL_ENCODING_SERVICE';
    const SERVICE_PROCESS = 'PROCESS_SERVICE';

    const DECODER = 'DECODER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addDefaultProcessesStack($container);
        $container = $this->addDefaultLoggerConfigPlugin($container);
        $container = $this->addLogHandlers($container);
        $container = $this->addLogProcessors($container);
        $container = $this->addProcessService($container);
        $container = $this->addGenericTranslatorFunctions($container);
        $container = $this->addGenericValidators($container);
        $container = $this->addDecoder($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
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
    protected function addConfigurationProfilesStack($container): Container
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
    protected function addDefaultProcessesStack($container): Container
    {
        $container[static::MIDDLEWARE_DEFAULT_PROCESSES] = function () {
            return $this->getDefaultProcessesPluginsStack();
        };

        return $container;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    protected function getDefaultProcessesPluginsStack(): array
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[]
     */
    protected function getConfigurationProfilePluginsStack(): array
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
    protected function addLogHandlers($container): Container
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
    protected function addLogProcessors($container): Container
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
    protected function addDefaultLoggerConfigPlugin($container): Container
    {
        $container[static::MIDDLEWARE_DEFAULT_LOG_CONFIG_PLUGIN] = function () {
            return $this->getDefaultLoggerConfigPlugin();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addGenericTranslatorFunctions($container): Container
    {
        $container[static::MIDDLEWARE_GENERIC_TRANSLATOR_FUNCTIONS] = function () {
            return $this->getGenericTranslatorFunctionsStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addGenericValidators($container): Container
    {
        $container[static::MIDDLEWARE_GENERIC_VALIDATORS] = function () {
            return $this->getGenericValidatorsStack();
        };

        return $container;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    protected function getDefaultLoggerConfigPlugin(): MiddlewareLoggerConfigPluginInterface
    {
        return new MiddlewareLoggerConfigPlugin();
    }

    /**
     * @return \Spryker\Shared\Log\Dependency\Plugin\LogHandlerPluginInterface[]
     */
    protected function getLogProcessors(): array
    {
        return [
            new PsrLogMessageProcessorPlugin(),
            new IntrospectionProcessorPlugin(),
        ];
    }

    /**
     * @return \Spryker\Shared\Log\Dependency\Plugin\LogProcessorPluginInterface[]
     */
    protected function getLogHandlers(): array
    {
        return [
            new StdErrStreamHandlerPlugin(),
        ];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\TranslatorFunctionPluginInterface[]
     */
    protected function getGenericTranslatorFunctionsStack(): array
    {
        return [
            new ArrayToStringTranslatorFunctionPlugin(),
            new BoolToStringTranslatorFunctionPlugin(),
            new DateTimeToStringTranslatorFunctionPlugin(),
            new EnumTranslatorFunctionPlugin(),
            new ExcludeKeysAssociativeFilterTranslatorFunctionPlugin(),
            new ExcludeValuesAssociativeFilterTranslatorFunctionPlugin(),
            new ExcludeValuesSequentalFilterTranslatorFunctionPlugin(),
            new FloatToIntTranslatorFunctionPlugin(),
            new FloatToStringTranslatorFunctionPlugin(),
            new IntToFloatTranslatorFunctionPlugin(),
            new IntToStringTranslatorFunctionPlugin(),
            new MoneyDecimalToIntegerTranslatorFunctionPlugin(),
            new MoneyIntegerToDecimalTranslatorFunctionPlugin(),
            new StringToArrayTranslatoFunctionPlugin(),
            new StringToBoolTranslatorFunctionPlugin(),
            new StringToDateTimeTranslatorFunctionPlugin(),
            new StringToFloatTranslatorFunctionPlugin(),
            new StringToIntTranslatorFunctionPlugin(),
            new WhitelistKeysAssociativeFilterTranslatorFunctionPlugin(),
        ];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\ValidatorPluginInterface[]
     */
    protected function getGenericValidatorsStack(): array
    {
        return [
            new DateTimeValidatorPlugin(),
            new EqualToValidatorPlugin(),
            new GreaterOrEqualThanValidatorPlugin(),
            new GreaterThanValidatorPlugin(),
            new InListValidatorPlugin(),
            new LengthValidatorPlugin(),
            new LessOrEqualThanValidatorPlugin(),
            new LessThanValidatorPlugin(),
            new NotBlankValidatorPlugin(),
            new NotEqualToValidatorPlugin(),
            new RegexValidatorPlugin(),
            new RequiredValidatorPlugin(),
            new TypeValidatorPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addDecoder($container)
    {
        $container[static::DECODER] = function () {
            return $this->createDecoder();
        };

        return $container;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapter
     */
    protected function getDecoder()
    {
        return new ProcessToSymfonyDecoderAdapter();
    }
}
