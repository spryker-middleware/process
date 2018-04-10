<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Generated\Shared\Transfer\ValidatorConfigTransfer;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManager;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface;
use SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot\ConfigurationSnapshotBuilder;
use SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot\ConfigurationSnapshotBuilderInterface;
use SprykerMiddleware\Zed\Process\Business\Mapper\Mapper;
use SprykerMiddleware\Zed\Process\Business\Mapper\MapperInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Pipeline;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\FingersCrossedProcessor;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\PipelineProcessorInterface;
use SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolver;
use SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface;
use SprykerMiddleware\Zed\Process\Business\Process\Processor;
use SprykerMiddleware\Zed\Process\Business\Process\ProcessorInterface;
use SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelper;
use SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelperInterface;
use SprykerMiddleware\Zed\Process\Business\Translator\Translator;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionPluginResolver;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionPluginResolverInterface;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorInterface;
use SprykerMiddleware\Zed\Process\Business\Validator\PayloadValidator;
use SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\Resolver\ValidatorPluginResolver;
use SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\Resolver\ValidatorPluginResolverInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface;
use SprykerMiddleware\Zed\Process\ProcessDependencyProvider;

/**
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 */
class ProcessBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Process\ProcessorInterface
     */
    public function createProcessor(
        ProcessSettingsTransfer $processSettingsTransfer
    ): ProcessorInterface {
        return new Processor(
            $processSettingsTransfer,
            $this->createPipeline($processSettingsTransfer),
            $this->createProcessPluginResolver(),
            $this->createProcessResultHelper()
        );
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface
     */
    public function createProcessPluginResolver(): ProcessPluginResolverInterface
    {
        return new ProcessPluginResolver($this->getProfileConfigurationPluginStack());
    }

    /**
     * @param \Generated\Shared\Transfer\MapperConfigTransfer $mapperConfigTransfer
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\MapperInterface
     */
    public function createMapper(MapperConfigTransfer $mapperConfigTransfer): MapperInterface
    {
        return new Mapper(
            $mapperConfigTransfer,
            $this->createArrayManager()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\TranslatorConfigTransfer $translatorConfigTransfer
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorInterface
     */
    public function createTranslator(TranslatorConfigTransfer $translatorConfigTransfer): TranslatorInterface
    {
        return new Translator(
            $translatorConfigTransfer,
            $this->createTranslatorFunctionResolver(),
            $this->createArrayManager()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ValidatorConfigTransfer $validatorConfigTransfer
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Validator\PayloadValidatorInterface
     */
    public function createPayloadValidator(ValidatorConfigTransfer $validatorConfigTransfer)
    {
        return new PayloadValidator(
            $validatorConfigTransfer,
            $this->createValidatorPluginResolver(),
            $this->createArrayManager()
        );
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface
     */
    public function createArrayManager(): ArrayManagerInterface
    {
        return new ArrayManager();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelperInterface
     */
    public function createProcessResultHelper(): ProcessResultHelperInterface
    {
        return new ProcessResultHelper($this->createConfigurationSnapshotBuilder());
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\ConfigurationSnapshot\ConfigurationSnapshotBuilderInterface
     */
    public function createConfigurationSnapshotBuilder(): ConfigurationSnapshotBuilderInterface
    {
        return new ConfigurationSnapshotBuilder();
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface
     */
    public function createPipeline(
        ProcessSettingsTransfer $processSettingsTransfer
    ): PipelineInterface {
        return new Pipeline(
            $this->createPipelineProcessor(),
            $this->createProcessPluginResolver(),
            $processSettingsTransfer
        );
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\PipelineProcessorInterface
     */
    public function createPipelineProcessor(): PipelineProcessorInterface
    {
        return new FingersCrossedProcessor($this->createProcessResultHelper());
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionPluginResolverInterface
     */
    public function createTranslatorFunctionResolver(): TranslatorFunctionPluginResolverInterface
    {
        return new TranslatorFunctionPluginResolver($this->getProfileConfigurationPluginStack());
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\Resolver\ValidatorPluginResolverInterface
     */
    public function createValidatorPluginResolver(): ValidatorPluginResolverInterface
    {
        return new ValidatorPluginResolver($this->getProfileConfigurationPluginStack());
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    public function getDefaultLoggerConfigPlugin(): MiddlewareLoggerConfigPluginInterface
    {
        return $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_DEFAULT_LOG_CONFIG_PLUGIN);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[]
     */
    public function getProfileConfigurationPluginStack(): array
    {
        return $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_CONFIGURATION_PROFILES);
    }
}
