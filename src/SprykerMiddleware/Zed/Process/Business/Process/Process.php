<?php
namespace SprykerMiddleware\Zed\Process\Business\Process;

use Iterator;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;

class Process implements ProcessInterface
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
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Iterator $iterator
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface $pipeline
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(Iterator $iterator, PipelineInterface $pipeline, LoggerInterface $logger)
    {
        $this->iterator = $iterator;
        $this->pipeline = $pipeline;
        $this->logger = $logger;
    }

    /**
     * @return void
     */
    public function process()
    {
        $this->logger->info('Middleware process is started.', ['process' => $this]);
        foreach ($this->iterator as $item) {
            $this->logger->info('Start processing of item', ['item' => $item]);
            $this->pipeline->process($item);
        }
        $this->logger->info('Middleware process is finished.');
    }
}
