<?php
namespace SprykerMiddleware\Zed\Process\Business\Process;

use Generated\Shared\Transfer\ProcessSettingsTransfer;
use SprykerMiddleware\Zed\Process\Business\Log\LoggerTrait;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface;

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
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface
     */
    protected $processPlugin;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface
     */
    protected $processPluginResolver;

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface $pipeline
     * @param \SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface $processPluginResolver
     * @param resource $inStream
     * @param resource $outStream
     */
    public function __construct(
        ProcessSettingsTransfer $processSettingsTransfer,
        PipelineInterface $pipeline,
        ProcessPluginResolverInterface $processPluginResolver,
        $inStream,
        $outStream
    ) {
        $this->processSettingsTransfer = $processSettingsTransfer;
        $this->pipeline = $pipeline;
        $this->processPluginResolver = $processPluginResolver;
        $this->inStream = $inStream;
        $this->outStream = $outStream;
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
        $this->processPlugin = $this->processPluginResolver
            ->getProcessConfigurationPluginByProcessName($this->processSettingsTransfer->getName());

        $this->iterator = $this->processPlugin
            ->getIteratorPlugin()
            ->getIterator($this->inStream, $this->processSettingsTransfer->getIteratorSettings());

        $this->preProcessStack = $this->processPlugin
            ->getPreProcessorHookPlugins();

        $this->postProcessStack = $this->processPlugin
            ->getPostProcessorHookPlugins();

        $loggerConfig = $this->processPlugin
            ->getLoggerPlugin();

        $loggerConfig->changeLogLevel($this->processSettingsTransfer->getLoggerSettings()->getVerboseLevel());

        $this->initLogger($loggerConfig);
    }
}
