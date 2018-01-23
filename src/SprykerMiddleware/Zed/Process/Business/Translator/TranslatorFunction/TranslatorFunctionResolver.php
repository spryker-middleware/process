<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver;
use SprykerMiddleware\Zed\Process\Business\Exception\TranslatorFunctionNotFoundException;

class TranslatorFunctionResolver extends AbstractClassResolver
{
    const CLASS_NAME_PATTERN = '\\%1$s\\Zed\\%2$s%4$s\\%3$s\\Translator\TranslatorFunction\%5$s';

    /**
     * @var string
     */
    protected $translationFunctionClassName;

    /**
     * @param object|string $callerClass
     * @param string $translationFunctionClassName
     * @param string $key
     * @param array $options
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\TranslatorFunctionNotFoundException
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunctionInterface
     */
    public function resolve($callerClass, string $translationFunctionClassName, string $key, array $options = [])
    {
        $this->setCallerClass($callerClass);
        $this->setTranslationFunctionClassName($translationFunctionClassName);
        if ($this->canResolve()) {
            return $this->getResolvedClassInstanceWithParams($key, $options);
        }

        throw new TranslatorFunctionNotFoundException($this->translationFunctionClassName);
    }

    /**
     * @return string
     */
    public function getClassPattern()
    {
        return sprintf(
            self::CLASS_NAME_PATTERN,
            self::KEY_NAMESPACE,
            self::KEY_BUNDLE,
            self::KEY_LAYER,
            self::KEY_STORE,
            $this->translationFunctionClassName
        );
    }

    /**
     * @param string $namespace
     * @param string|null $store
     *
     * @return string
     */
    protected function buildClassName($namespace, $store = null)
    {
        $searchAndReplace = [
            self::KEY_NAMESPACE => $namespace,
            self::KEY_BUNDLE => $this->getClassInfo()->getBundle(),
            self::KEY_LAYER => $this->getClassInfo()->getLayer(),
            self::KEY_STORE => $store,
        ];

        $className = str_replace(
            array_keys($searchAndReplace),
            array_values($searchAndReplace),
            $this->getClassPattern()
        );

        return $className;
    }

    /**
     * @param string $translationFunctionClassName
     *
     * @return void
     */
    protected function setTranslationFunctionClassName(string $translationFunctionClassName)
    {
        $this->translationFunctionClassName = $translationFunctionClassName;
    }

    /**
     * @param string $key
     * @param array $options
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunctionInterface
     */
    protected function getResolvedClassInstanceWithParams(string $key, array $options)
    {
        $instance = $this->getResolvedClassInstance();
        $instance->setKey($key);
        $instance->setOptions($options);
        return $instance;
    }

    /**
     * @return string
     */
    protected function buildCacheKey(): string
    {
        return get_class($this) . '-' . $this->translationFunctionClassName;
    }
}
