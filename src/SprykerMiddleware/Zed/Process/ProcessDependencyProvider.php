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
use SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule\ArrayMapRulePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule\ClosureMapRulePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule\DynamicArrayMapRulePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule\DynamicMapRulePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\MapRule\KeyMapRulePlugin;
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
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapterInterface;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapter;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapterInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Service\ProcessToUtilEncodingServiceBridge;

class ProcessDependencyProvider extends AbstractBundleDependencyProvider
{
    public const MIDDLEWARE_PROCESSES = 'MIDDLEWARE_PROCESSES';
    public const MIDDLEWARE_CONFIGURATION_PROFILES = 'MIDDLEWARE_CONFIGURATION_PROFILES';
    public const MIDDLEWARE_LOG_HANDLERS = 'MIDDLEWARE_LOG_HANDLERS';
    public const MIDDLEWARE_LOG_PROCESSORS = 'MIDDLEWARE_LOG_PROCESSORS';
    public const MIDDLEWARE_LOG_CONFIG_PLUGIN = 'MIDDLEWARE_LOG_CONFIG_PLUGIN';
    public const MIDDLEWARE_TRANSLATOR_FUNCTIONS = 'MIDDLEWARE_TRANSLATOR_FUNCTIONS';
    public const MIDDLEWARE_VALIDATORS = 'MIDDLEWARE_VALIDATORS';
    public const MIDDLEWARE_MAPPERS = 'MIDDLEWARE_MAPPERS';

    public const SERVICE_UTIL_ENCODING = 'UTIL_ENCODING_SERVICE';
    public const SERVICE_PROCESS = 'PROCESS_SERVICE';

    public const DECODER = 'DECODER';
    public const ENCODER = 'ENCODER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addProcessesStack($container);
        $container = $this->addMiddlewareLoggerConfigPlugin($container);
        $container = $this->addLogHandlers($container);
        $container = $this->addLogProcessors($container);
        $container = $this->addProcessService($container);
        $container = $this->addTranslatorFunctions($container);
        $container = $this->addValidators($container);
        $container = $this->addDecoder($container);
        $container = $this->addEncoder($container);
        $container = $this->addEncodingService($container);

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
        $container = $this->addConfigurationMappersStack($container);

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
    protected function addConfigurationMappersStack($container): Container
    {
        $container[static::MIDDLEWARE_MAPPERS] = function () {
            return $this->getConfigurationMappersPluginsStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProcessesStack($container): Container
    {
        $container[static::MIDDLEWARE_PROCESSES] = function () {
            return $this->getProcessesPluginsStack();
        };

        return $container;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    protected function getProcessesPluginsStack(): array
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
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\MapRule\MapRulePluginInterface[]
     */
    protected function getConfigurationMappersPluginsStack(): array
    {
        return [
            new ArrayMapRulePlugin(),
            new DynamicMapRulePlugin(),
            new ClosureMapRulePlugin(),
            new DynamicArrayMapRulePlugin(),
            new KeyMapRulePlugin(),
        ];
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
    protected function addMiddlewareLoggerConfigPlugin($container): Container
    {
        $container[static::MIDDLEWARE_LOG_CONFIG_PLUGIN] = function () {
            return $this->getMiddlewareLoggerConfigPlugin();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addTranslatorFunctions($container): Container
    {
        $container[static::MIDDLEWARE_TRANSLATOR_FUNCTIONS] = function () {
            return $this->getTranslatorFunctionsStack();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addValidators($container): Container
    {
        $container[static::MIDDLEWARE_VALIDATORS] = function () {
            return $this->getValidatorsStack();
        };

        return $container;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    protected function getMiddlewareLoggerConfigPlugin(): MiddlewareLoggerConfigPluginInterface
    {
        return new MiddlewareLoggerConfigPlugin();
    }

    /**
     * @return \Spryker\Shared\Log\Dependency\Plugin\LogProcessorPluginInterface[]
     */
    protected function getLogProcessors(): array
    {
        return [
            new PsrLogMessageProcessorPlugin(),
            new IntrospectionProcessorPlugin(),
        ];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLogHandlerPluginInterface[]
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
    protected function getTranslatorFunctionsStack(): array
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
    protected function getValidatorsStack(): array
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
            return $this->getDecoder();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEncoder($container)
    {
        $container[static::ENCODER] = function () {
            return $this->getEncoder();
        };

        return $container;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapterInterface
     */
    protected function getDecoder(): ProcessToSymfonyDecoderAdapterInterface
    {
        return new ProcessToSymfonyDecoderAdapter();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapterInterface
     */
    protected function getEncoder(): ProcessToSymfonyEncoderAdapterInterface
    {
        return new ProcessToSymfonyEncoderAdapter();
    }
}
