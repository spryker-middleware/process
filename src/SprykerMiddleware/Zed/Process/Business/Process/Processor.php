<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Process;

use Generated\Shared\Transfer\ProcessResultTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use SprykerMiddleware\Shared\Logger\Logger\MiddlewareLoggerTrait;
use SprykerMiddleware\Zed\Process\Business\Exception\TolerableProcessException;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface;
use SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelperInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OptionAwareStreamPluginInterface;
use Throwable;

class Processor implements ProcessorInterface
{
    use MiddlewareLoggerTrait;

    /**
     * @var \Generated\Shared\Transfer\ProcessSettingsTransfer
     */
    protected $processSettingsTransfer;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Iterator\IteratorInterface
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
     * @var \SprykerMiddleware\Shared\Process\Stream\ReadStreamInterface
     */
    protected $inputStream;

    /**
     * @var \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
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
     * @var \Generated\Shared\Transfer\ProcessResultTransfer
     */
    protected $processResultTransfer;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelperInterface
     */
    protected $processResultHelper;

    /**
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface $pipeline
     * @param \SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface $processPluginResolver
     * @param \SprykerMiddleware\Zed\Process\Business\ProcessResult\ProcessResultHelperInterface $processResultHelper
     */
    public function __construct(
        ProcessSettingsTransfer $processSettingsTransfer,
        PipelineInterface $pipeline,
        ProcessPluginResolverInterface $processPluginResolver,
        ProcessResultHelperInterface $processResultHelper
    ) {
        $this->processSettingsTransfer = $processSettingsTransfer;
        $this->pipeline = $pipeline;
        $this->processPluginResolver = $processPluginResolver;
        $this->processResultHelper = $processResultHelper;
        $this->processResultTransfer = new ProcessResultTransfer();
        $this->init();
    }

    /**
     * @return void
     */
    public function process(): void
    {
        $this->preProcess();
        $this->getProcessLogger()->info('Middleware process is started.', ['process' => $this]);
        $counter = 0;
        try {
            $this->inputStream->open();
            $this->outputStream->open();
            foreach ($this->iterator as $item) {
                $this->processResultHelper->increaseItemCount($this->processResultTransfer);
                try {
                    $this->getProcessLogger()->info('Start processing of item', [
                        'itemNo' => $counter++,
                    ]);
                    $this->pipeline->process($item, $this->outputStream, $this->processResultTransfer);
                    $this->processResultHelper->increaseProcessedItemCount($this->processResultTransfer);
                } catch (TolerableProcessException $exception) {
                    $this->processResultHelper->increaseSkippedItemCount($this->processResultTransfer);
                    $this->getProcessLogger()->error('Experienced tolerable process error in ' . $exception->getFile(), ['exception' => $exception]);
                }
            }
            $this->outputStream->flush();
        } catch (Throwable $e) {
            $this->processResultHelper->increaseFailedItemCount($this->processResultTransfer);
            $this->getProcessLogger()->error('Middleware process was stopped. Non tolerable error was occurred.', ['exception' => $e, 'item' => isset($item) ? $item : null]);
        } finally {
            $this->inputStream->close();
            $this->outputStream->close();
        }
        $this->processResultTransfer->setEndTime(time());
        $this->getProcessLogger()->info('Middleware process is finished.');
        $this->postProcess();
    }

    /**
     * @return void
     */
    public function preProcess(): void
    {
        foreach ($this->preProcessStack as $preProcessor) {
            $preProcessor->process($this->processResultTransfer);
        }
    }

    /**
     * @return void
     */
    public function postProcess(): void
    {
        foreach ($this->postProcessStack as $postProcessor) {
            $postProcessor->process($this->processResultTransfer);
        }
    }

    /**
     * @return void
     */
    protected function init(): void
    {
        $this->processPlugin = $this->processPluginResolver
            ->getProcessConfigurationPluginByProcessName($this->processSettingsTransfer->getName());

        $inputStreamPlugin = $this->processPlugin->getInputStreamPlugin();
        if ($inputStreamPlugin instanceof OptionAwareStreamPluginInterface) {
            $inputStreamPlugin->setOptions($this->processSettingsTransfer->getInputStreamOptions());
        }
        $this->inputStream = $inputStreamPlugin->getInputStream($this->processSettingsTransfer->getInputPath());

        $outputStreamPlugin = $this->processPlugin->getOutputStreamPlugin();
        if ($outputStreamPlugin instanceof OptionAwareStreamPluginInterface) {
            $outputStreamPlugin->setOptions($this->processSettingsTransfer->getOutputStreamOptions());
        }
        $this->outputStream = $outputStreamPlugin->getOutputStream($this->processSettingsTransfer->getOutputPath());

        $this->iterator = $this->processPlugin
            ->getIteratorPlugin()
            ->getIterator($this->inputStream, $this->processSettingsTransfer->getIteratorConfig());

        $this->preProcessStack = $this->processPlugin
            ->getPreProcessorHookPlugins();

        $this->postProcessStack = $this->processPlugin
            ->getPostProcessorHookPlugins();

        $loggerConfig = $this->processPlugin
            ->getLoggerPlugin();

        $loggerConfig->changeLogLevel($this->processSettingsTransfer->getLoggerConfig()->getVerboseLevel());

        $this->initLogger($loggerConfig);
        $this->processResultHelper->initProcessResultTransfer($this->processResultTransfer, $this->processPlugin, $this->processSettingsTransfer);
    }
}
