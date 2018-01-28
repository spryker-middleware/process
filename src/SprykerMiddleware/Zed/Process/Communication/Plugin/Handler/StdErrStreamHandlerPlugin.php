<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Handler;

use Monolog\Formatter\FormatterInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLogHandlerPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 */
class StdErrStreamHandlerPlugin extends AbstractPlugin implements MiddlewareLogHandlerPluginInterface
{
    /**
     * @var \Monolog\Handler\AbstractHandler
     */
    protected $handler;

    /**
     * @return \Monolog\Handler\AbstractHandler
     */
    protected function getHandler()
    {
        if (!$this->handler) {
            $this->handler = $this->getFactory()->createStdErrStreamHandler();
        }

        return $this->handler;
    }

    /**
     * @param array $record
     *
     * @return bool
     */
    public function isHandling(array $record)
    {
        return $this->getHandler()->isHandling($record);
    }

    /**
     * @param array $record
     *
     * @return bool
     */
    public function handle(array $record)
    {
        return $this->getHandler()->handle($record);
    }

    /**
     * @param array $records
     *
     * @return void
     */
    public function handleBatch(array $records)
    {
        $this->getHandler()->handleBatch($records);
    }

    /**
     * @param callable $callback
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    public function pushProcessor($callback)
    {
        return $this->getHandler()->pushProcessor($callback);
    }

    /**
     * @return callable
     */
    public function popProcessor()
    {
        return $this->getHandler()->popProcessor();
    }

    /**
     * @param \Monolog\Formatter\FormatterInterface $formatter
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        return $this->getHandler()->setFormatter($formatter);
    }

    /**
     * @return \Monolog\Formatter\FormatterInterface
     */
    public function getFormatter()
    {
        return $this->getHandler()->getFormatter();
    }

    /**
     * @param int|string $level
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    public function setLevel($level)
    {
        return $this->getHandler()->setLevel($level);
    }
}
