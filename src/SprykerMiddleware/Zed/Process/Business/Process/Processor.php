<?php
namespace SprykerMiddleware\Zed\Process\Business\Process;

use Iterator;
use SprykerMiddleware\Zed\Process\Business\Aggregator\AggregatorInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;

class Processor implements ProcessorInterface
{
    /**
     * @var \Iterator
     */
    protected $iterator;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Aggregator\AggregatorInterface
     */
    protected $aggregator;

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
     * Processor constructor.
     *
     * @param \Iterator $iterator
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface $pipeline
     * @param \SprykerMiddleware\Zed\Process\Business\Aggregator\AggregatorInterface $aggregator
     * @param array $preProcessStack
     * @param array $postProcessStack
     */
    public function __construct(
        Iterator $iterator,
        PipelineInterface $pipeline,
        AggregatorInterface $aggregator,
        array $preProcessStack,
        array $postProcessStack
    ) {
        $this->iterator = $iterator;
        $this->pipeline = $pipeline;
        $this->aggregator = $aggregator;
        $this->preProcessStack = $preProcessStack;
        $this->postProcessStack = $postProcessStack;
    }

    /**
     * @return void
     */
    public function process()
    {
        $this->preProcess();
        foreach ($this->iterator as $item) {
            $this->aggregator->accept(
                $this->pipeline->process($item)
            );
        }
        $this->aggregator->flush();
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
