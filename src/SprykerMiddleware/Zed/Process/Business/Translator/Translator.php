<?php


namespace SprykerMiddleware\Zed\Process\Business\Translator;

class Translator implements TranslatorInterface
{
    /**
     * @var array
     */
    protected $dictionary;

    /**
     * @param array $dictionary
     */
    public function __construct(array $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function translate(array $payload): array
    {
        return $payload;
    }
}
