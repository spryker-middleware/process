<?php
namespace SprykerMiddleware\Zed\Process\Communication;

use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Iterator;
use League\Pipeline\FingersCrossedProcessor;
use Spryker\Shared\Log\Config\LoggerConfigInterface;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerMiddleware\Zed\Process\Business\Log\Config\MiddlewareLoggerConfig;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Pipeline;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\Stage;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface;
use SprykerMiddleware\Zed\Process\Business\Process\Process;
use SprykerMiddleware\Zed\Process\Business\Process\ProcessInterface;
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
     * @return \SprykerMiddleware\Zed\Process\Business\Process\ProcessInterface
     */
    public function createProcess(ProcessSettingsTransfer $processSettingsTransfer): ProcessInterface
    {
        return new Process(
            $this->getProcessIterator($processSettingsTransfer),
            $this->createPipeline($this->getStagePluginsListForProcess($processSettingsTransfer->getName())),
            $this->getLogger($this->getProcessLogConfig($processSettingsTransfer))
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
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface
     */
    public function createPipeline(array $stagePlugins): PipelineInterface
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
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     *
     * @return \Spryker\Shared\Log\Config\LoggerConfigInterface
     */
    protected function getProcessLogConfig(ProcessSettingsTransfer $processSettingsTransfer): LoggerConfigInterface
    {
        $configuration = $this->getProcessLoggerList();
        if (isset($configuration[$processSettingsTransfer->getName()])) {
            return $configuration[$processSettingsTransfer->getName()];
        }
        return $this->createMiddlewareLogConfig();
    }

    /**
     * @return array
     */
    protected function getProcessLoggerList(): array
    {
        return [];
    }

    /**
     * @return \Spryker\Shared\Log\Config\LoggerConfigInterface
     */
    protected function createMiddlewareLogConfig()
    {
        return new MiddlewareLoggerConfig();
    }
}
