<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\StreamConfigurator;

interface StreamConfiguratorInterface
{
    /**
     * @param array $options
     *
     * @return array
     */
    public function resolveOptions(array $options): array;
}
