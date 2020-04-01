<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream;

/**
 * Use this plugin if you need configurable options in input or output stream.
 */
interface OptionAwareStreamPluginInterface
{
    /**
     * Specification:
     *  - Sets options to input/output stream.
     *
     * @api
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options);
}
