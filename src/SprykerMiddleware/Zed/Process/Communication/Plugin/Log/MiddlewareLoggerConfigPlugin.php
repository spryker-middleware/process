<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Log;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class MiddlewareLoggerConfigPlugin extends AbstractPlugin implements MiddlewareLoggerConfigPluginInterface
{
    protected const CHANNEL_NAME = 'SprykerMiddleware';
    protected const PLUGIN_NAME = 'MiddlewareLoggerConfigPlugin';

    /**
     * @var \Monolog\Handler\AbstractHandler[]
     */
    protected $handlers;

    /**
     * @return string
     */
    public function getChannelName(): string
    {
        return static::CHANNEL_NAME;
    }

    /**
     * @return \Monolog\Handler\AbstractHandler[]
     */
    public function getHandlers(): array
    {
        if ($this->handlers) {
            return $this->handlers;
        }

        return $this->getFactory()->getMiddlewareLogHandlers();
    }

    /**
     * @return callable[]
     */
    public function getProcessors(): array
    {
        return $this->getFactory()->getMiddlewareLogProcessors();
    }

    /**
     * Sets minimum logging level at which all handlers will be triggered.
     *
     * @param int|string $level Level or level name
     *
     * @return void
     */
    public function changeLogLevel($level): void
    {
        $this->handlers = $this->getFactory()->getMiddlewareLogHandlers();
        foreach ($this->handlers as $handler) {
            $handler->setLevel($level);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
