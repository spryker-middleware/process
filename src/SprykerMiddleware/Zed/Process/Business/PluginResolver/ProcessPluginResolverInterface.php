<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\PluginResolver;

use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;

interface ProcessPluginResolverInterface
{
    /**
     * @param string $processName
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface
     */
    public function getProcessConfigurationPluginByProcessName(string $processName): ProcessConfigurationPluginInterface;
}
