<?php

namespace SprykerMiddleware\Zed\Process\Business;

use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver;
use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;
use SprykerMiddleware\Zed\Process\Business\Mapper\Mapper;
use SprykerMiddleware\Zed\Process\Business\Mapper\MapperInterface;
use SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManager;
use SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface;
use SprykerMiddleware\Zed\Process\Business\Translator\Translator;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionResolver;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorInterface;
use SprykerMiddleware\Zed\Process\Business\Writer\WriterInterface;
use SprykerMiddleware\Zed\Process\Business\Writer\WriterResolver;

/**
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 */
class ProcessBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @param \SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface $map
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\MapperInterface
     */
    public function createMapper(MapInterface $map): MapperInterface
    {
        return new Mapper(
            $map,
            $this->createPayloadManager()
        );
    }
    
    /**
     * @param array $dictionary
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorInterface
     */
    public function createTranslator(array $dictionary, LoggerInterface $logger): TranslatorInterface
    {
        return new Translator(
            $dictionary,
            $this->createTranslatorFunctionResolver(),
            $this->createPayloadManager(),
            $logger
        );
    }

    /**
     * @param string $writerName
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Writer\WriterInterface
     */
    public function createWriter(string $writerName): WriterInterface
    {
        return $this->createWriterResolver()->resolve($this, $writerName);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface
     */
    public function createPayloadManager(): PayloadManagerInterface
    {
        return new PayloadManager();
    }

    /**
     * @return \Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver
     */
    protected function createTranslatorFunctionResolver(): AbstractClassResolver
    {
        return new TranslatorFunctionResolver();
    }

    /**
     * @return \Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver
     */
    protected function createWriterResolver(): AbstractClassResolver
    {
        return new WriterResolver();
    }
}
