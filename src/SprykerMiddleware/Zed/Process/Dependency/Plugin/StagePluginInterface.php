<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin;

use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;

interface StagePluginInterface
{
    public const STAGE_TYPE_MAPPER = 'STAGE_TYPE_MAPPER';
    public const STAGE_TYPE_TRANSLATOR = 'STAGE_TYPE_TRANSLATOR';
    public const STAGE_TYPE_VALIDATOR = 'STAGE_TYPE_VALIDATOR';
    public const STAGE_TYPE_READER = 'STAGE_TYPE_READER';
    public const STAGE_TYPE_WRITER = 'STAGE_TYPE_WRITER';
    public const STAGE_TYPE_CUSTOM = 'STAGE_TYPE_CUSTOM';

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param mixed $originalPayload
     *
     * @return mixed
     */
    public function process($payload, WriteStreamInterface $outStream, $originalPayload);
}
