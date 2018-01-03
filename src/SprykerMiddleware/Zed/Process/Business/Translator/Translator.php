<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator;

use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface;

class Translator implements TranslatorInterface
{
    const OPERATION = 'Translation';

    const KEY_OPTIONS = 'options';
    const KEY_KEY = 'key';
    const KEY_OPERATION_TYPE = 'operation_type';
    const KEY_AFFECTED_DATA = 'affected_data';
    const KEY_RESULTED_DATA = 'resulted_data';

    /**
     * @var \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    protected $translatorConfigTransfer;

    /**
     * @var \Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver
     */
    protected $translatorFunctionResolver;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface
     */
    protected $arrayManager;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Generated\Shared\Transfer\TranslatorConfigTransfer $translatorConfigTransfer
     * @param \Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver $translatorFunctionResolver
     * @param \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface $arrayManager
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        TranslatorConfigTransfer $translatorConfigTransfer,
        AbstractClassResolver $translatorFunctionResolver,
        ArrayManagerInterface $arrayManager,
        LoggerInterface $logger
    ) {
        $this->translatorConfigTransfer = $translatorConfigTransfer;
        $this->translatorFunctionResolver = $translatorFunctionResolver;
        $this->arrayManager = $arrayManager;
        $this->logger = $logger;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function translate(array $payload): array
    {
        $result = $payload;
        foreach ($this->translatorConfigTransfer->getDictionary() as $key => $translations) {
            $result = $this->translateKey($result, $payload, $key, $translations);
        }

        return $result;
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $translation
     *
     * @return array
     */
    protected function translateKey(array $result, array $payload, string $key, $translation): array
    {
        if (!strstr($key, '*')) {
            return $this->translateByRuleSet($result, $payload, $key, $translation);
        }

        return $this->translateNestedKeys($result, $payload, $key, $translation);
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $translation
     *
     * @return array
     */
    protected function translateByRuleSet(array $result, array $payload, string $key, $translation): array
    {
        if (is_array($translation)) {
            foreach ($translation as $rule) {
                $result = $this->translateByRule($result, $payload, $key, $rule);
            }
            return $result;
        }

        return $this->translateByRule($result, $payload, $key, $translation);
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $translation
     *
     * @return array
     */
    protected function translateByRule(array $result, array $payload, string $key, $translation): array
    {
        if (is_callable($translation)) {
            return $this->translateCallable($result, $payload, $key, $translation);
        }
        if (is_array($translation)) {
            return $this->translateValue($result, $payload, $key, $translation);
        }
        if (is_string($translation)) {
            return $this->translateValue($result, $payload, $key, [$translation]);
        }

        return $result;
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param callable $translation
     *
     * @return array
     */
    protected function translateCallable(array $result, array $payload, string $key, callable $translation): array
    {
        $inputValue = $this->arrayManager->getValueByKey($payload, $key);
        $resultValue = $translation($inputValue, $key, $result);
        $this->logger->debug(
            static::OPERATION,
            [
                static::KEY_KEY => $key,
                static::KEY_OPERATION_TYPE => $translation,
                static::KEY_AFFECTED_DATA => $inputValue,
                static::KEY_RESULTED_DATA => $resultValue,
            ]
        );

        return $this->arrayManager->putValue($result, $key, $resultValue);
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param array $translation
     *
     * @return array
     */
    protected function translateValue(array $result, array $payload, string $key, array $translation): array
    {
        $options = isset($translation[static::KEY_OPTIONS]) ? $translation[static::KEY_OPTIONS] : [];
        /** @var \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface $translateFunction */
        $translateFunction = $this->translatorFunctionResolver->resolve($this, reset($translation), $options);

        $inputValue = $this->arrayManager->getValueByKey($result, $key);
        $resultValue = $translateFunction->translate($inputValue);
        $this->logger->debug(
            static::OPERATION,
            [
                static::KEY_KEY => $key,
                static::KEY_OPERATION_TYPE => reset($translation),
                static::KEY_AFFECTED_DATA => $inputValue,
                static::KEY_RESULTED_DATA => $resultValue,
            ]
        );

        return $this->arrayManager->putValue($result, $key, $resultValue);
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $translation
     *
     * @return array
     */
    protected function translateNestedKeys(array $result, array $payload, string $key, $translation): array
    {
        $keys = $this->arrayManager->getAllNestedKeys($result, $key);
        foreach ($keys as $key) {
            $result = $this->translateByRuleSet($result, $payload, $key, $translation);
        }

        return $result;
    }
}
