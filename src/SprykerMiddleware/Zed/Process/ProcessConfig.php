<?php

namespace SprykerMiddleware\Zed\Process;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class ProcessConfig extends AbstractBundleConfig
{
    /**
     * @return array
     */
    public function getProcessesConfig()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getProcessIteratorsConfig()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getPreProcessorHooksConfig()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getPostProcessorHooksConfig()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getProcessLoggersConfig()
    {
        return [];
    }
}
