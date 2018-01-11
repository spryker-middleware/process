<?php
namespace SprykerMiddleware\Zed\Process\Business\Process;

use Exception;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use SprykerMiddleware\Zed\Process\Business\Exception\TolerableProcessException;
use SprykerMiddleware\Zed\Process\Business\Log\LoggerTrait;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface;
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
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface
     */
    protected $processPlugin;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface
     */
    protected $processPluginResolver;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Stream\Resolver\StreamPluginResolverInterface
     */
    private $streamPluginResolver;

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface $pipeline
     * @param \SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface $processPluginResolver
     * @param \SprykerMiddleware\Zed\Process\Business\Stream\Resolver\StreamPluginResolverInterface $streamPluginResolver
     */
    public function __construct(
        ProcessSettingsTransfer $processSettingsTransfer,
        PipelineInterface $pipeline,
        ProcessPluginResolverInterface $processPluginResolver,
        StreamPluginResolverInterface $streamPluginResolver
    ) {
        $this->processSettingsTransfer = $processSettingsTransfer;
        $this->pipeline = $pipeline;
        $this->processPluginResolver = $processPluginResolver;
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
        } catch (TolerableProcessException $exception) {
            $this->getLogger()->error('Experienced tolerable process error in ' . $exception->getFile());
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

        $this->processPlugin = $this->processPluginResolver
            ->getProcessConfigurationPluginByProcessName($this->processSettingsTransfer->getName());

        $this->iterator = $this->processPlugin
            ->getIteratorPlugin()
            ->getIterator($this->inputStream, $this->processSettingsTransfer->getIteratorSettings());

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
