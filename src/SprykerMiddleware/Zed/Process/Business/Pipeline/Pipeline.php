<?php
namespace SprykerMiddleware\Zed\Process\Business\Pipeline;

use SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\PipelineProcessorInterface;

class Pipeline implements PipelineInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[]
     */
    protected $stages = [];

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\PipelineProcessorInterface
     */
    protected $processor;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\PipelineProcessorInterface $processor
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[] $stages
     */
    public function __construct(PipelineProcessorInterface $processor, array $stages)
    {
        $this->processor = $processor;
        $this->stages = $stages;
    }

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface|callable $stage
     *
     * @return static
     */
    public function pipe(callable $stage)
    {
        $pipeline = clone $this;
        $pipeline->stages[] = $stage;

        return $pipeline;
    }

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     *
     * @return mixed
     */
    public function process($payload, ReadStreamInterface $inStream, WriteStreamInterface $outStream)
    {
        return $this->processor->process($this->stages, $payload, $inStream, $outStream);
    }

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface $inStream
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     *
     * @return mixed
     */
    public function __invoke($payload, ReadStreamInterface $inStream, WriteStreamInterface $outStream)
    {
        return $this->process($payload, $inStream, $outStream);
    }
}
