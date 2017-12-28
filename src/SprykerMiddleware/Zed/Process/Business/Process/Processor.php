<?php
namespace SprykerMiddleware\Zed\Process\Business\Process;

use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Iterator;
use Psr\Log\LoggerInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface;

class Processor implements ProcessorInterface
{
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
    protected $outstream;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param \Iterator $iterator
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface $pipeline
     * @param \SprykerMiddleware\Zed\Process\Business\PluginFinder\PluginFinderInterface $pluginFinder
     * @param resource $outstream
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        ProcessSettingsTransfer $processSettingsTransfer,
        Iterator $iterator,
        PipelineInterface $pipeline,
        PluginFinderInterface $pluginFinder,
        $outstream,
        LoggerInterface $logger
    ) {
        $this->processSettingsTransfer = $processSettingsTransfer;
        $this->iterator = $iterator;
        $this->pipeline = $pipeline;
        $this->preProcessStack = $pluginFinder->getPreProcessorHookPluginsByProcessName($this->processSettingsTransfer->getName());
        $this->postProcessStack = $pluginFinder->getPostProcessorHookPluginsByProcessName($this->processSettingsTransfer->getName());
        ;
        $this->logger = $logger;
        $this->outstream = $outstream;
    }

    /**
     * @return void
     */
    public function process()
    {
        $this->preProcess();
        $this->logger->info('Middleware process is started.', ['process' => $this]);
        $counter = 0;
        foreach ($this->iterator as $item) {
            $this->logger->info('Start processing of item', [
                'itemNo' => $counter++,
            ]);
            $this->pipeline->process($item);
        }
        fflush($this->outstream);
        $this->logger->info('Middleware process is finished.');
        $this->postProcess();
    }

    /**
     * @return void
     */
    public function preProcess()
    {
        foreach ($this->preProcessStack as $preProcessor) {
            $preProcessor->process();
        }
    }

    /**
     * @return void
     */
    public function postProcess()
    {
        foreach ($this->postProcessStack as $postProcessor) {
            $postProcessor->process();
        }
    }
}
