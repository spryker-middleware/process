<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Handler;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractHandler;
use Monolog\Handler\HandlerInterface;
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
    protected function getHandler(): AbstractHandler
    {
        if (!$this->handler) {
            $this->handler = $this->getFactory()->createStdErrStreamHandler();
        }

        return $this->handler;
    }

    /**
     * @api
     *
     * @param array $record
     *
     * @return bool
     */
    public function isHandling(array $record): bool
    {
        return $this->getHandler()->isHandling($record);
    }

    /**
     * @api
     *
     * @param array $record
     *
     * @return bool
     */
    public function handle(array $record): bool
    {
        return $this->getHandler()->handle($record);
    }

    /**
     * @api
     *
     * @param array $records
     *
     * @return void
     */
    public function handleBatch(array $records): void
    {
        $this->getHandler()->handleBatch($records);
    }

    /**
     * @api
     *
     * @param callable $callback
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    public function pushProcessor($callback): HandlerInterface
    {
        return $this->getHandler()->pushProcessor($callback);
    }

    /**
     * @api
     *
     * @return callable
     */
    public function popProcessor(): callable
    {
        return $this->getHandler()->popProcessor();
    }

    /**
     * @api
     *
     * @param \Monolog\Formatter\FormatterInterface $formatter
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    public function setFormatter(FormatterInterface $formatter): HandlerInterface
    {
        return $this->getHandler()->setFormatter($formatter);
    }

    /**
     * @api
     *
     * @return \Monolog\Formatter\FormatterInterface
     */
    public function getFormatter(): FormatterInterface
    {
        return $this->getHandler()->getFormatter();
    }

    /**
     * @api
     *
     * @param int|string $level
     *
     * @return \Monolog\Handler\HandlerInterface
     */
    public function setLevel($level): HandlerInterface
    {
        return $this->getHandler()->setLevel($level);
    }
}
