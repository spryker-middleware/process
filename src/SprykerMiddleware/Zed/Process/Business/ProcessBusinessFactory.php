<?php

namespace SprykerMiddleware\Zed\Process\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver;
use SprykerMiddleware\Zed\Process\Business\Log\Config\MiddlewareLoggerConfig;
use SprykerMiddleware\Zed\Process\Business\Mapper\Mapper;
use SprykerMiddleware\Zed\Process\Business\Mapper\MapperInterface;
use SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManager;
use SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Pipeline;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageListBuilder;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageListBuilderInterface;
use SprykerMiddleware\Zed\Process\Business\Process\Processor;
use SprykerMiddleware\Zed\Process\Business\Process\ProcessorInterface;
use SprykerMiddleware\Zed\Process\Business\Translator\Translator;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionResolver;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorInterface;
use SprykerMiddleware\Zed\Process\ProcessDependencyProvider;

/**
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 */
class ProcessBusinessFactory extends AbstractBusinessFactory
{
    use LoggerTrait;

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Process\ProcessorInterface
     */
    public function createProcessor(ProcessSettingsTransfer $processSettingsTransfer): ProcessorInterface
    {

        $stagesPluginsList = $this->getStagePluginsListForProcess($processSettingsTransfer->getName());
        $logger = $this->getLogger($this->getProcessLoggerConfig($processSettingsTransfer));
        return new Processor(
            $this->getProcessIterator($processSettingsTransfer),
            $this->createPipeline($stagesPluginsList, $logger),
            $this->getPreProcessHookStack($processSettingsTransfer->getName()),
            $this->getPostProcessHookStack($processSettingsTransfer->getName()),
            $logger
        );
    }

    /**
     * @param string $processName
     *
     * @return array
     */
    protected function getStagePluginsListForProcess(string $processName): array
    {
        $stages = $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_PROCESS_STAGES);
        return $stages[$processName];
    }

    /**
     * @param string $processName
     *
     * @return array
     */
    protected function getPreProcessHookStack(string $processName): array
    {
        $preProcessHooks = $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK);
        return $preProcessHooks[$processName];
    }

    /**
     * @param string $processName
     *
     * @return array
     */
    protected function getPostProcessHookStack(string $processName): array
    {
        $postProcessHooks = $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK);
        return $postProcessHooks[$processName]?:[];
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \Iterator
     */
    protected function getProcessIterator(ProcessSettingsTransfer $processSettingsTransfer): Iterator
    {
        $iterators = $this->getProcessIteratorsList();
        return $iterators[$processSettingsTransfer->getName()]($processSettingsTransfer->getIteratorSettings());
    }

    /**
     * @return array
     */
    protected function getProcessIteratorsList(): array
    {
        return [];
    }

    /**
     * @param \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface[] $stagePlugins
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface
     */
    protected function createPipeline(array $stagePlugins, LoggerInterface $logger): PipelineInterface
    {
        return new Pipeline(
            $this->createPipelineProcessor(),
            $this->getStages($stagePlugins, $logger)
        );
    }

    /**
     * @param \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface[] $stagePlugins
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[]
     */
    protected function getStages(array $stagePlugins, LoggerInterface $logger): array
    {
        return $this->createStageListBuilder()
            ->buildStageList($stagePlugins, $logger);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageListBuilderInterface
     */
    protected function createStageListBuilder(): StageListBuilderInterface
    {
        return new StageListBuilder();
    }

    /**
     * @return \League\Pipeline\FingersCrossedProcessor
     */
    protected function createPipelineProcessor(): FingersCrossedProcessor
    {
        return new FingersCrossedProcessor();
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \Spryker\Shared\Log\Config\LoggerConfigInterface
     */
    protected function getProcessLoggerConfig(ProcessSettingsTransfer $processSettingsTransfer): LoggerConfigInterface
    {
        $configuration = $this->getProcessLoggerConfigList();
        if (isset($configuration[$processSettingsTransfer->getName()])) {
            return $configuration[$processSettingsTransfer->getName()]($processSettingsTransfer->getLoggerSettings());
        }
        return $this->createMiddlewareLogConfig($processSettingsTransfer->getLoggerSettings());
    }

    /**
     * @return array
     */
    protected function getProcessLoggerConfigList(): array
    {
        return [];
    }

    /**
     * @param \Generated\Shared\Transfer\LoggerSettingsTransfer $loggerSettingsTransfer
     *
     * @return \Spryker\Shared\Log\Config\LoggerConfigInterface
     */
    protected function createMiddlewareLogConfig(LoggerSettingsTransfer $loggerSettingsTransfer): LoggerConfigInterface
    {
        return new MiddlewareLoggerConfig($loggerSettingsTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MapperConfigTransfer $mapperConfigTransfer
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\MapperInterface
     */
    public function createMapper(MapInterface $map): MapperInterface
    {
        return new Mapper(
            $map,
            $this->createPayloadManager()
        );
    }

    /**
     * @param array $dictionary
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorInterface
     */
    public function createTranslator(array $dictionary): TranslatorInterface
    {
        return new Translator(
            $dictionary,
            $this->createTranslatorFunctionResolver(),
            $this->createPayloadManager()
        );
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface
     */
    public function createPayloadManager(): PayloadManagerInterface
    {
        return new PayloadManager();
    }

    /**
     * @return \Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver
     */
    protected function createTranslatorFunctionResolver(): AbstractClassResolver
    {
        return new TranslatorFunctionResolver();
    }
}
