<?php
namespace SprykerMiddleware\Zed\Process\Communication;

use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Iterator;
use League\Pipeline\FingersCrossedProcessor;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerMiddleware\Zed\Process\Business\Aggregator\AggregatorInterface;
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
    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Process\ProcessorInterface
     */
    public function createProcessor(ProcessSettingsTransfer $processSettingsTransfer): ProcessorInterface
    {
        return new Processor(
            $this->getProcessIterator($processSettingsTransfer),
            $this->createPipeline($this->getStagePluginsListForProcess($processSettingsTransfer->getName())),
            $this->getProcessAggregator($processSettingsTransfer),
            $this->getPreProcessorStack($processSettingsTransfer->getName()),
            $this->getPostProcessorStack($processSettingsTransfer->getName())
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
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Aggregator\AggregatorInterface
     */
    protected function getProcessAggregator(ProcessSettingsTransfer $processSettingsTransfer): AggregatorInterface
    {
        $aggregators = $this->getProcessAggregatorsList();
        return $aggregators[$processSettingsTransfer->getName()]($processSettingsTransfer->getAggregatorSettings());
    }

    /**
     * @return array
     */
    protected function getProcessAggregatorsList(): array
    {
        return [];
    }

    /**
     * @param \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface[] $stagePlugins
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface
     */
    protected function createPipeline(array $stagePlugins): PipelineInterface
    {
        return new Pipeline(
            $this->createPipelineProcessor(),
            $this->getStages($stagePlugins)
        );
    }

    /**
     * @param \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface[] $stagePlugins
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[]
     */
    protected function getStages(array $stagePlugins): array
    {
        $stages = [];
        foreach ($stagePlugins as $stagePlugin) {
            $stages[] = $this->createStage($stagePlugin);
        }

        return $stages;
    }

    /**
     * @param \SprykerMiddleware\Zed\Process\Communication\Plugin\StagePluginInterface $stagePlugin
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface
     */
    protected function createStage(StagePluginInterface $stagePlugin): StageInterface
    {
        return new Stage($stagePlugin);
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
}
