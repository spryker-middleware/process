<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\AbstractHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\IntrospectionProcessor;
use Psr\Log\LogLevel;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerMiddleware\Zed\Process\Business\Iterator\IteratorFactory;
use SprykerMiddleware\Zed\Process\Business\Stream\StreamFactory;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionFactory;
use SprykerMiddleware\Zed\Process\ProcessDependencyProvider;

/**
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 */
class ProcessCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Iterator\IteratorFactory
     */
    public function createIteratorFactory(): IteratorFactory
    {
        return new IteratorFactory();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Stream\StreamFactory
     */
    public function createStreamFactory(): StreamFactory
    {
        return new StreamFactory();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionFactory
     */
    public function createTranslatorFunctionFactory(): TranslatorFunctionFactory
    {
        return new TranslatorFunctionFactory();
    }

    /**
     * @return callable
     */
    public function createIntrospectionProcessor(): callable
    {
        return new IntrospectionProcessor();
    }

    /**
     * @return \SprykerMiddleware\Service\Process\ProcessServiceInterface
     */
    public function getProcessService()
    {
        return $this->getProvidedDependency(ProcessDependencyProvider::SERVICE_PROCESS);
    }

    /**
     * @return \Monolog\Handler\AbstractHandler[]
     */
    public function getMiddlewareLogHandlers()
    {
        return $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_LOG_HANDLERS);
    }

    /**
     * @return callable[]
     */
    public function getMiddlewareLogProcessors()
    {
        return $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_LOG_PROCESSORS);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    public function getDefaultProcessesPlugins()
    {
        return $this->getProvidedDependency(ProcessDependencyProvider::MIDDLEWARE_DEFAULT_PROCESSES);
    }

    /**
     * @return \Monolog\Handler\AbstractHandler
     */
    public function createStdErrStreamHandler(): AbstractHandler
    {
        $streamHandler = new StreamHandler(
            'php://stderr',
            LogLevel::DEBUG
        );
        $formatter = $this->createLogstashFormatter();
        $streamHandler->setFormatter($formatter);

        return $streamHandler;
    }

    /**
     * @return \Monolog\Formatter\FormatterInterface|\Monolog\Formatter\FormatterInterface
     */
    protected function createLogstashFormatter(): FormatterInterface
    {
        return new LogstashFormatter(APPLICATION);
    }
}
