<?php

namespace SprykerMiddleware\Zed\Process\Business;

use Generated\Shared\Transfer\LoggerSettingsTransfer;
use Generated\Shared\Transfer\MapperConfigTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Iterator;
use League\Pipeline\FingersCrossedProcessor;
use League\Pipeline\ProcessorInterface as LeagueProcessorInterface;
use Psr\Log\LoggerInterface;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver;
use SprykerMiddleware\Service\Process\ProcessServiceInterface;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManager;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface;
use SprykerMiddleware\Zed\Process\Business\Log\Config\MiddlewareLoggerConfig;
use SprykerMiddleware\Zed\Process\Business\Mapper\Mapper;
use SprykerMiddleware\Zed\Process\Business\Mapper\MapperInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Pipeline;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageListBuilder;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageListBuilderInterface;
use SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinder;
use SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface;
use SprykerMiddleware\Zed\Process\Business\Process\Processor;
use SprykerMiddleware\Zed\Process\Business\Process\ProcessorInterface;
use SprykerMiddleware\Zed\Process\Business\Reader\JsonReader;
use SprykerMiddleware\Zed\Process\Business\Reader\ReaderInterface;
use SprykerMiddleware\Zed\Process\Business\Translator\Translator;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionResolver;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorInterface;
use SprykerMiddleware\Zed\Process\Business\Writer\JsonWriter;
use SprykerMiddleware\Zed\Process\ProcessDependencyProvider;

/**
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 */
class ProcessBusinessFactory extends AbstractBusinessFactory
{
    use LoggerTrait;

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param resource $inStream
     * @param resource $outStream
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Process\ProcessorInterface
     */
    public function createProcessor(
        ProcessSettingsTransfer $processSettingsTransfer,
        $inStream,
        $outStream
    ): ProcessorInterface {
        $logger = $this->getLogger($this->getProcessLoggerConfig($processSettingsTransfer));
        return new Processor(
            $processSettingsTransfer,
            $this->createPipeline($processSettingsTransfer, $inStream, $outStream, $logger),
            $this->createPluginFinder(),
            $inStream,
            $outStream,
            $logger
        );
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface
     */
    public function createPluginFinder(): PluginFinderInterface
    {
        return new PluginFinder(
            $this->getConfig(),
            $this->getStagePluginsStack(),
            $this->getIteratorsStack(),
            $this->getPreProcessHookStack(),
            $this->getPostProcessHookStack()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\MapperConfigTransfer $mapperConfigTransfer
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\MapperInterface
     */
    public function createMapper(MapperConfigTransfer $mapperConfigTransfer, LoggerInterface $logger): MapperInterface
    {
        return new Mapper(
            $mapperConfigTransfer,
            $this->createArrayManager(),
            $logger
        );
    }

    /**
     * @param \Generated\Shared\Transfer\TranslatorConfigTransfer $translatorConfigTransfer
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorInterface
     */
    public function createTranslator(TranslatorConfigTransfer $translatorConfigTransfer, LoggerInterface $logger): TranslatorInterface
    {
        return new Translator(
            $translatorConfigTransfer,
            $this->createTranslatorFunctionResolver(),
            $this->createArrayManager(),
            $logger
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
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Reader\ReaderInterface
     */
    public function createJsonReader(LoggerInterface $logger): ReaderInterface
    {
        return new JsonReader($this->getProcessService(), $logger);
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Writer\WriterInterface
     */
    public function createJsonWriter($logger)
    {
        return new JsonWriter($this->getProcessService(), $logger);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[]
     */
    protected function getPreProcessHookStack(): array
    {
        return $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_PRE_PROCESSOR_HOOKS_STACK);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[]
     */
    protected function getPostProcessHookStack(): array
    {
        return $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_POST_PROCESSOR_HOOKS_STACK);
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param resource $inStream
     *
     * @return \Iterator
     */
    protected function createProcessIterator(ProcessSettingsTransfer $processSettingsTransfer, $inStream): Iterator
    {
        $processes = $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_PROCESSES);
        $iteratorClassName = $processes[$processSettingsTransfer->getName()][ProcessDependencyProvider::ITERATOR];
        return new $iteratorClassName($inStream);
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param resource $inStream
     * @param resource $outStream
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface
     */
    protected function createPipeline(
        ProcessSettingsTransfer $processSettingsTransfer,
        $inStream,
        $outStream,
        LoggerInterface $logger
    ): PipelineInterface {
        return new Pipeline(
            $this->createPipelineProcessor(),
            $this->getStages($processSettingsTransfer, $inStream, $outStream, $logger)
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param resource $inStream
     * @param resource $outStream
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[]
     */
    protected function getStages(
        ProcessSettingsTransfer $processSettingsTransfer,
        $inStream,
        $outStream,
        LoggerInterface $logger
    ): array {

        return $this->createStageListBuilder()
            ->buildStageList($processSettingsTransfer, $inStream, $outStream, $logger);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageListBuilderInterface
     */
    protected function createStageListBuilder(): StageListBuilderInterface
    {
        return new StageListBuilder(
            $this->createPluginFinder()
        );
    }

    /**
     * @return \League\Pipeline\ProcessorInterface
     */
    protected function createPipelineProcessor(): LeagueProcessorInterface
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
     * @return \Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver
     */
    protected function createTranslatorFunctionResolver(): AbstractClassResolver
    {
        return new TranslatorFunctionResolver();
    }

    /**
     * @return \SprykerMiddleware\Service\Process\ProcessServiceInterface
     */
    protected function getProcessService(): ProcessServiceInterface
    {
        return $this->getProvidedDependency(ProcessDependencyProvider::SERVICE_PROCESS);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[]
     */
    protected function getStagePluginsStack(): array
    {
        return $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_STAGE_PLUGINS);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface[]
     */
    protected function getIteratorsStack()
    {
        return $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_PROCESS_ITERATORS);
    }
}
