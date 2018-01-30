<?php

namespace SprykerMiddleware\Zed\Process;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class ProcessConfig extends AbstractBundleConfig
{
    /**
     * @example array('processName' => array('StagePlugin1Name', 'StagePlugin2Name'))
     *
     * @return array
     */
    public function getProcessesConfig()
    {
        return [];
    }

    /**
     * @example array('processName' => 'IteratorPluginName')
     *
     * @return array
     */
    public function getProcessIteratorsConfig()
    {
        return [];
    }

    /**
     * @example array('processName' => array('PreProcessorHooksPlugin1Name', 'PreProcessorHooksPlugin2Name'))
     *
     * @return array
     */
    public function getPreProcessorHooksConfig()
    {
        return [];
    }

    /**
     * @example array('processName' => array('PostProcessorHooksPlugin1Name', 'PostProcessorHooksPlugin2Name'))
     *
     * @return array
     */
    public function getPostProcessorHooksConfig()
    {
        return [];
    }

    /**
     * @example array('processName' => 'LoggerConfigPluginName')
     *
     * @return array
     */
    public function getProcessLoggersConfig()
    {
        return [];
    }
}
