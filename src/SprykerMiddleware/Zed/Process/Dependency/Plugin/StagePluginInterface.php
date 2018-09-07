<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin;

use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface StagePluginInterface
{
    /**
     * @api
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Specification:
     *  - This plugin adds stage to Middleware process pipeline.
     *  - Can be used in process configuration
     *
     * To provide standard stages you can use follow methods from SprykerMiddleware\ProcessFacade:
     *  - Validator: `ProcessFacade::validate($payload, $validatorConfigTransfer)`
     *  - Mapper: `ProcessFacade::map($payload, $mapperConfigTransfer)`
     *  - Translator: `ProcessFacade::translate($payload, $translatorConfigTransfer)`
     *
     * @api
     *
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param mixed $originalPayload
     *
     * @return mixed
     */
    public function process($payload, WriteStreamInterface $outStream, $originalPayload);
}
