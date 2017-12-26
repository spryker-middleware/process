<?php
namespace SprykerMiddleware\Zed\Process\Business\Process;

use Iterator;
use Psr\Log\LoggerInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;

class Processor implements ProcessorInterface
{
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
     * @param \Iterator $iterator
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface $pipeline
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[] $preProcessStack
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[] $postProcessStack
     * @param resource $outstream
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Iterator $iterator,
        PipelineInterface $pipeline,
        array $preProcessStack,
        array $postProcessStack,
        $outstream,
        LoggerInterface $logger
    ) {
        $this->iterator = $iterator;
        $this->pipeline = $pipeline;
        $this->preProcessStack = $preProcessStack;
        $this->postProcessStack = $postProcessStack;
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
