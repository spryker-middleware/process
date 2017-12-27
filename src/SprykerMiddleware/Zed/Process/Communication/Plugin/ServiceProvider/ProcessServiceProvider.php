<?php

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\ServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Business\Stream\JsonStream;

class ProcessServiceProvider extends AbstractPlugin implements ServiceProviderInterface
{

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function register(Application $app)
    {
        stream_wrapper_register('jsonstreamwriter', JsonStream::class);
        stream_wrapper_register('jsonstreamreader', JsonStream::class);
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function boot(Application $app)
    {
    }
}