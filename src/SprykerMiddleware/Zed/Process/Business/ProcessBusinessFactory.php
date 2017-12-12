<?php

namespace SprykerMiddleware\Zed\Process\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver;
use SprykerMiddleware\Zed\Process\Business\Mapper\Mapper;
use SprykerMiddleware\Zed\Process\Business\Mapper\MapperInterface;
use SprykerMiddleware\Zed\Process\Business\Translator\Translator;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionResolver;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 */
class ProcessBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @param array $map
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\MapperInterface
     */
    public function createMapper(array $map): MapperInterface
    {
        return new Mapper($map);
    }

    /**
     * @param array $dictionary
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorInterface
     */
    public function createTranslator(array $dictionary): TranslatorInterface
    {
        return new Translator($dictionary, $this->createTranslatorFunctionResolver());
    }

    /**
     * @return \Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver
     */
    protected function createTranslatorFunctionResolver(): AbstractClassResolver
    {
        return new TranslatorFunctionResolver();
    }
}
