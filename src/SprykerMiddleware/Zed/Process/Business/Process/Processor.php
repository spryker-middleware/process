<?php
namespace SprykerMiddleware\Zed\Process\Business\Process;

use Generated\Shared\Transfer\ProcessSettingsTransfer;
use SprykerMiddleware\Zed\Process\Business\Log\LoggerTrait;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\PluginFinder\LoggerConfigPluginFinderInterface;
use SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface;

class Processor implements ProcessorInterface
{
    use LoggerTrait;

    /**
     * @var \Generated\Shared\Transfer\ProcessSettingsTransfer
     */
    protected $processSettingsTransfer;

    /**
     * @var \Iterator
     */
    protected $iterator;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface
     */
    protected $pipeline;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[]
     */
    protected $preProcessStack;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[]
     */
    protected $postProcessStack;

    /**
     * @var resource
     */
    protected $inStream;

    /**
     * @var resource
     */
    protected $outStream;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface
     */
    protected $pluginFinder;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PluginFinder\LoggerConfigPluginFinderInterface
     */
    protected $loggerConfigPluginFinder;

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface $pipeline
     * @param \SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface $pluginFinder
     * @param \SprykerMiddleware\Zed\Process\Business\PluginFinder\LoggerConfigPluginFinderInterface $loggerConfigPluginFinder
     * @param resource $inStream
     * @param resource $outStream
     */
    public function __construct(
        ProcessSettingsTransfer $processSettingsTransfer,
        PipelineInterface $pipeline,
        PluginFinderInterface $pluginFinder,
        LoggerConfigPluginFinderInterface $loggerConfigPluginFinder,
        $inStream,
        $outStream
    ) {
        $this->processSettingsTransfer = $processSettingsTransfer;
        $this->pipeline = $pipeline;
        $this->pluginFinder = $pluginFinder;
        $this->inStream = $inStream;
        $this->outStream = $outStream;
        $this->loggerConfigPluginFinder = $loggerConfigPluginFinder;
        $this->init();
    }

    /**
     * @return void
     */
    public function process(): void
    {
        $this->preProcess();
        $this->getLogger()->info('Middleware process is started.', ['process' => $this]);
        $counter = 0;
        foreach ($this->iterator as $item) {
            $this->getLogger()->info('Start processing of item', [
                'itemNo' => $counter++,
            ]);
            $this->pipeline->process($item);
        }
        fflush($this->outStream);
        $this->getLogger()->info('Middleware process is finished.');
        $this->postProcess();
    }

    /**
     * @return void
     */
    public function preProcess(): void
    {
        foreach ($this->preProcessStack as $preProcessor) {
            $preProcessor->process();
        }
    }

    /**
     * @return void
     */
    public function postProcess(): void
    {
        foreach ($this->postProcessStack as $postProcessor) {
            $postProcessor->process();
        }
    }

    /**
     * @return void
     */
    protected function init(): void
    {
        $this->iterator = $this->pluginFinder
            ->getIteratorPluginByProcessName($this->processSettingsTransfer->getName())
            ->getIterator($this->inStream, $this->processSettingsTransfer->getIteratorSettings());
        $this->preProcessStack = $this->pluginFinder
            ->getPreProcessorHookPluginsByProcessName($this->processSettingsTransfer->getName());
        $this->postProcessStack = $this->pluginFinder
            ->getPostProcessorHookPluginsByProcessName($this->processSettingsTransfer->getName());
        $loggerConfig = $this->loggerConfigPluginFinder
            ->getLoggerConfigPluginByProcessName($this->processSettingsTransfer->getName());
        $loggerConfig->changeLogLevel($this->processSettingsTransfer->getLoggerSettings()->getVerboseLevel());
        $this->initLogger($loggerConfig);
    }
}
