<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator;

use Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver;
use SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface;

class Translator implements TranslatorInterface
{
    const KEY_OPTIONS = 'options';
    /**
     * @var array
     */
    protected $dictionary;

    /**
     * @var \Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver
     */
    protected $translatorFunctionResolver;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface
     */
    protected $payloadManager;

    /**
     * @param array $dictionary
     * @param \Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver $translatorFunctionResolver
     * @param \SprykerMiddleware\Zed\Process\Business\PayloadManager\PayloadManagerInterface $payloadManager
     */
    public function __construct(
        array $dictionary,
        AbstractClassResolver $translatorFunctionResolver,
        PayloadManagerInterface $payloadManager
    ) {
        $this->dictionary = $dictionary;
        $this->translatorFunctionResolver = $translatorFunctionResolver;
        $this->payloadManager = $payloadManager;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function translate(array $payload): array
    {
        $result = $payload;
        foreach ($this->dictionary as $key => $translations) {
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
            return $this->payloadManager
                ->setValue($result, $key, $translation($this->payloadManager->getValueByKey($payload, $key), $key, $result));
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
     * @param array $translation
     *
     * @return array
     */
    protected function translateValue(array $result, array $payload, string $key, array $translation): array
    {
        $options = isset($translation[self::KEY_OPTIONS]) ? $translation[self::KEY_OPTIONS] : [];
        /** @var \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface $translateFunction */
        $translateFunction = $this->translatorFunctionResolver->resolve($this, reset($translation), $options);
        $value = $translateFunction->translate($this->payloadManager->getValueByKey($result, $key));

        return $this->payloadManager->setValue($result, $key, $value);
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
        $keys = $this->payloadManager->getAllNestedKeys($payload, $key);
        foreach ($keys as $key) {
            $result = $this->translateByRuleSet($result, $payload, $key, $translation);
        }

        return $result;
    }
}
