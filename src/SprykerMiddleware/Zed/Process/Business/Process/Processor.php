<?php
namespace SprykerMiddleware\Zed\Process\Business\Process;

use Exception;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use SprykerMiddleware\Zed\Process\Business\Log\LoggerTrait;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\PluginFinder\LoggerConfigPluginFinderInterface;
use SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface;
use SprykerMiddleware\Zed\Process\Business\Stream\Resolver\StreamPluginResolverInterface;

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
     * @var \SprykerMiddleware\Shared\Process\Stream\StreamInterface
     */
    protected $inputStream;

    /**
     * @var \SprykerMiddleware\Shared\Process\Stream\StreamInterface
     */
    protected $outputStream;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface
     */
    protected $pluginFinder;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PluginFinder\LoggerConfigPluginFinderInterface
     */
    protected $loggerConfigPluginFinder;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Stream\Resolver\StreamPluginResolverInterface
     */
    private $streamPluginResolver;

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface $pipeline
     * @param \SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface $pluginFinder
     * @param \SprykerMiddleware\Zed\Process\Business\PluginFinder\LoggerConfigPluginFinderInterface $loggerConfigPluginFinder
     * @param \SprykerMiddleware\Zed\Process\Business\Stream\Resolver\StreamPluginResolverInterface $streamPluginResolver
     */
    public function __construct(
        ProcessSettingsTransfer $processSettingsTransfer,
        PipelineInterface $pipeline,
        PluginFinderInterface $pluginFinder,
        LoggerConfigPluginFinderInterface $loggerConfigPluginFinder,
        StreamPluginResolverInterface $streamPluginResolver
    ) {
        $this->processSettingsTransfer = $processSettingsTransfer;
        $this->pipeline = $pipeline;
        $this->pluginFinder = $pluginFinder;
        $this->loggerConfigPluginFinder = $loggerConfigPluginFinder;
        $this->streamPluginResolver = $streamPluginResolver;
        $this->init();
    }

    /**
     * @throws \Exception
     *
     * @return void
     */
    public function process(): void
    {
        $this->preProcess();
        $this->getLogger()->info('Middleware process is started.', ['process' => $this]);
        $counter = 0;
        try {
            $this->inputStream->open('r');
            $this->outputStream->open('w');
            foreach ($this->iterator as $item) {
                $this->getLogger()->info('Start processing of item', [
                    'itemNo' => $counter++,
                ]);
                $this->pipeline->process($item, $this->inputStream, $this->outputStream);
            }
            $this->outputStream->flush();
        } catch (Exception $e) {
            throw $e;
        } finally {
            $this->inputStream->close();
            $this->outputStream->close();
        }

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
        $this->inputStream = $this->streamPluginResolver
            ->getStreamPluginByPath($this->processSettingsTransfer->getInputPath())
            ->getStream($this->processSettingsTransfer->getInputPath());

        $this->outputStream = $this->streamPluginResolver
            ->getStreamPluginByPath($this->processSettingsTransfer->getOutputPath())
            ->getStream($this->processSettingsTransfer->getOutputPath());

        $this->iterator = $this->pluginFinder
            ->getIteratorPluginByProcessName($this->processSettingsTransfer->getName())
            ->getIterator($this->inputStream, $this->processSettingsTransfer->getIteratorSettings());
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
