<?php
namespace SprykerMiddleware\Zed\Process\Communication;

use Generated\Shared\Transfer\LoggerSettingsTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Iterator;
use League\Pipeline\FingersCrossedProcessor;
use Psr\Log\LoggerInterface;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerMiddleware\Zed\Process\Business\Log\Config\MiddlewareLoggerConfig;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Pipeline;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\Stage;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface;
use SprykerMiddleware\Zed\Process\Business\Process\Processor;
use SprykerMiddleware\Zed\Process\Business\Process\ProcessorInterface;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface;
use SprykerMiddleware\Zed\Process\ProcessDependencyProvider;

/**
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 */
class ProcessCommunicationFactory extends AbstractCommunicationFactory
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
            $this->getPreProcessorStack($processSettingsTransfer->getName()),
            $this->getPostProcessorStack($processSettingsTransfer->getName()),
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
        $stages = [];
        foreach ($stagePlugins as $stagePlugin) {
            $stages[] = $this->createStage($stagePlugin, $logger);
        }

        return $stages;
    }

    /**
     * @param \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface $stagePlugin
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface
     */
    protected function createStage(StagePluginInterface $stagePlugin, LoggerInterface $logger): StageInterface
    {
        return new Stage($stagePlugin, $logger);
    }

    /**
     * @return \League\Pipeline\FingersCrossedProcessor
     */
    protected function createPipelineProcessor(): FingersCrossedProcessor
    {
        return new FingersCrossedProcessor();
    }

    /**
     * @param string $processName
     *
     * @return array
     */
    protected function getPreProcessorStack(string $processName): array
    {
        $hooks = $this->getRegisteredPreProcessorsList();
        if (isset($hooks[$processName])) {
            return $hooks[$processName];
        }
        return [];
    }

    /**
     * @param string $processName
     *
     * @return array
     */
    protected function getPostProcessorStack(string $processName): array
    {
        $hooks = $this->getRegisteredPostProcessorsList();
        if (isset($hooks[$processName])) {
            return $hooks[$processName];
        }
        return [];
    }

    /**
     * @return array
     */
    protected function getRegisteredPreProcessorsList(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getRegisteredPostProcessorsList(): array
    {
        return [];
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
}
