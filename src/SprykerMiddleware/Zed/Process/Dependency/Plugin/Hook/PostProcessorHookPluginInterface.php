<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook;

use Generated\Shared\Transfer\ProcessResultTransfer;

interface PostProcessorHookPluginInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param \Generated\Shared\Transfer\ProcessResultTransfer|null $processResultTransfer
     *
     * @return void
     */
    public function process(?ProcessResultTransfer $processResultTransfer = null): void;
}
