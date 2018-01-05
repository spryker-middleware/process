<?php
namespace SprykerMiddleware\Zed\Process\Business\Pipeline;

use League\Pipeline\ProcessorInterface;
use SprykerMiddleware\Shared\Process\Stream\StreamInterface;

class Pipeline implements PipelineInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[]
     */
    protected $stages = [];

    /**
     * @var \League\Pipeline\ProcessorInterface
     */
    protected $processor;

    /**
     * @param \League\Pipeline\ProcessorInterface $processor
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\Stage\StageInterface[] $stages
     */
    public function __construct(ProcessorInterface $processor, array $stages)
    {
        $this->processor = $processor;
        $this->stages = $stages;
    }

    /**
     * Create a new pipeline with an appended stage.
     *
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
     * Process the payload.
     *
     * @param mixed $payload
     *
     * @return mixed
     */
    public function process($payload)
    {
        return $this->processor->process($this->stages, $payload);
    }

    /**
     * @inheritdoc
     */
    public function __invoke($payload)
    {
        return $this->process($payload);
    }

    /**
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $inputStream
     * @param \SprykerMiddleware\Shared\Process\Stream\StreamInterface $outputStream
     *
     * @return void
     */
    public function setStreams(StreamInterface $inputStream, StreamInterface $outputStream)
    {
        foreach ($this->stages as $stage) {
            $stage->getStagePlugin()->setInStream($inputStream);
            $stage->getStagePlugin()->setOutStream($outputStream);
        }
    }
}
