<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Pipeline;

use Generated\Shared\Transfer\ProcessResultTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\PipelineProcessorInterface;
use SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface;

class Pipeline implements PipelineInterface
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[]
     */
    protected $stages = [];

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface
     */
    protected $pluginResolver;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\PipelineProcessorInterface
     */
    protected $pipelineProcessor;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\Pipeline\Processor\PipelineProcessorInterface $pipelineProcessor
     * @param \SprykerMiddleware\Zed\Process\Business\PluginResolver\ProcessPluginResolverInterface $pluginResolver
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer
     */
    public function __construct(
        PipelineProcessorInterface $pipelineProcessor,
        ProcessPluginResolverInterface $pluginResolver,
        ProcessSettingsTransfer $processSettingsTransfer
    ) {
        $this->pipelineProcessor = $pipelineProcessor;
        $this->pluginResolver = $pluginResolver;
        $this->stages = $this->pluginResolver
            ->getProcessConfigurationPluginByProcessName($processSettingsTransfer->getName())
            ->getStagePlugins();
    }

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param \Generated\Shared\Transfer\ProcessResultTransfer $processResultTransfer
     *
     * @return mixed
     */
    public function process($payload, WriteStreamInterface $outStream, ProcessResultTransfer $processResultTransfer)
    {
        return $this->pipelineProcessor->process($this->stages, $payload, $outStream, $processResultTransfer);
    }
}
