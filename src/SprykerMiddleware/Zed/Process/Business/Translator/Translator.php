<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator;

use Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver;

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
     * @param array $dictionary
     * @param \Spryker\Zed\Kernel\ClassResolver\AbstractClassResolver $translatorFunctionResolver
     */
    public function __construct(array $dictionary, AbstractClassResolver $translatorFunctionResolver)
    {
        $this->dictionary = $dictionary;
        $this->translatorFunctionResolver = $translatorFunctionResolver;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function translate(array $payload): array
    {
        $result = [];
        foreach ($this->dictionary as $key => $translation) {
            $result = $this->translateByRule($result, $payload, $key, $translation);
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
    protected function translateByRule(array $result, array $payload, string $key, $translation): array
    {
        if (is_callable($translation)) {
            return $this->setValue($result, $key, $translation($this->getValueByKey($payload, $key)));
        }
        if (is_array($translation)) {
            return $this->translateValue($result, $payload, $key, $translation);
        }

        return $result;
    }

    /**
     * @param mixed $payload
     * @param string $keyString
     *
     * @return mixed
     */
    protected function getValueByKey($payload, string $keyString)
    {
        $keys = explode('.', $keyString);
        $value = $payload;
        foreach ($keys as $key) {
            if (!isset($value[$key])) {
                return null;
            }
            $value = $value[$key];
        }

        return $value;
    }

    /**
     * @param array $result
     * @param string $key
     * @param mixed $value
     *
     * @return array
     */
    protected function setValue(array $result, string $key, $value): array
    {
        $keys = explode('.', $key);
        $temp = &$result;
        foreach ($keys as $key) {
            if (!isset($temp[$key])) {
                $temp[$key] = [];
            }
            $temp = &$temp[$key];
        }
        $temp = $value;

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
        $value = $translateFunction->translate($this->getValueByKey($payload, $key));
        return $this->setValue($result, $key, $value);
    }
}
