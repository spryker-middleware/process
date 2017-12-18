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
     * @var \SprykerMiddleware\Zed\Process\Business\Process\Hook\PreProcessorHookInterface[]
     */
    protected $preProcessStack;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Process\Hook\PostProcessorHookInterface[]
     */
    protected $postProcessStack;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Iterator $iterator
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface $pipeline
     * @param \SprykerMiddleware\Zed\Process\Business\Process\Hook\PreProcessorHookInterface[] $preProcessStack
     * @param \SprykerMiddleware\Zed\Process\Business\Process\Hook\PostProcessorHookInterface[] $postProcessStack
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Iterator $iterator,
        PipelineInterface $pipeline,
        array $preProcessStack,
        array $postProcessStack,
        LoggerInterface $logger
    ) {
        $this->iterator = $iterator;
        $this->pipeline = $pipeline;
        $this->preProcessStack = $preProcessStack;
        $this->postProcessStack = $postProcessStack;
        $this->logger = $logger;
    }

    /**
     * @return void
     */
    public function process()
    {
        $this->preProcess();
        $this->logger->info('Middleware process is started.', ['process' => $this]);
        foreach ($this->iterator as $item) {
            $this->logger->info('Start processing of item', ['item' => $item]);
            $this->pipeline->process($item);
        }
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
