<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Process;

use Exception;
use Generated\Shared\Transfer\ProcessResultTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use SprykerMiddleware\Shared\Process\Log\MiddlewareLoggerTrait;
use SprykerMiddleware\Zed\Process\Business\Exception\TolerableProcessException;
use SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface;
use SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface;

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
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\PipelineInterface $pipeline
     * @param \SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface $processPluginResolver
     */
    public function __construct(
        ProcessSettingsTransfer $processSettingsTransfer,
        PipelineInterface $pipeline,
        ProcessPluginResolverInterface $processPluginResolver
    ) {
        $this->processSettingsTransfer = $processSettingsTransfer;
        $this->pipeline = $pipeline;
        $this->processPluginResolver = $processPluginResolver;
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
        $this->getProcessLogger()->info('Middleware process is started.', ['process' => $this]);
        $counter = 0;
        try {
            $this->inputStream->open('r');
            $this->outputStream->open('w');
            foreach ($this->iterator as $item) {
                try {
                    $this->getProcessLogger()->info('Start processing of item', [
                        'itemNo' => $counter++,
                    ]);
                    $this->pipeline->process($item, $this->outputStream);
                } catch (TolerableProcessException $exception) {
                    $this->getProcessLogger()->error('Experienced tolerable process error in ' . $exception->getFile(), ['exception' => $exception]);
                }
            }
            $this->outputStream->flush();
        } catch (Exception $e) {
            $this->processResultTransfer->setFailedCount(1);
            $this->getProcessLogger()->error('Experienced process error in ' . $this->processSettingsTransfer->getName(), ['exception' => $e, 'item' => isset($item) ? $item : null]);
            throw $e;
        } finally {
            $this->inputStream->close();
            $this->outputStream->close();
        }

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

        $this->inputStream = $this->processPlugin
            ->getInputStreamPlugin()
            ->getInputStream($this->processSettingsTransfer->getInputPath());

        $this->outputStream = $this->processPlugin
            ->getOutputStreamPlugin()
            ->getOutputStream($this->processSettingsTransfer->getOutputPath());

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

        $this->initProcessResultTransfer();
    }

    /**
     * @return void
     */
    private function initProcessResultTransfer()
    {
        $this->processResultTransfer = new ProcessResultTransfer();
        $this->processResultTransfer->setStartTime(time());
        $this->processResultTransfer->setProcessName($this->processSettingsTransfer->getName());
        $this->processResultTransfer->setItemCount(0);
        $this->processResultTransfer->setSkippedCount(0);
        $this->processResultTransfer->setProcessedCount(0);
        $this->processResultTransfer->setFailedCount(0);
    }
}
