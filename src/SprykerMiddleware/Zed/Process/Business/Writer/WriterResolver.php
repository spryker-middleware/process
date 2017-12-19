<?php

namespace SprykerMiddleware\Zed\Process\Business\Writer;

use Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver;
use SprykerMiddleware\Zed\Process\Business\Exception\WriterNotFoundException;

class WriterResolver extends AbstractClassResolver
{
    const CLASS_NAME_PATTERN = '\\%1$s\\Zed\\%2$s%4$s\\%3$s\\Writer\%5$s';

    /**
     * @var string
     */
    protected $writerClassName;

    /**
     * @param object|string $callerClass
     * @param string $writerClassName
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WriterNotFoundException
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Writer\WriterInterface
     */
    public function resolve($callerClass, string $writerClassName)
    {
        $this->setCallerClass($callerClass);
        $this->setWriterClassName($writerClassName);
        if ($this->canResolve()) {
            return $this->getResolvedClassInstance();
        }

        throw new WriterNotFoundException($this->writerClassName);
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
            $this->writerClassName
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
     * @param string $writerClassName
     *
     * @return void
     */
    protected function setWriterClassName(string $writerClassName)
    {
        $this->writerClassName = $writerClassName;
    }

    /**
     * @return string
     */
    protected function buildCacheKey(): string
    {
        return get_class($this) . '-' . $this->writerClassName;
    }
}