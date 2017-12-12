<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator;

interface TranslatorInterface
{
    /**
     * @param array $payload
     *
     * @return array
     */
    public function translate(array $payload): array;
}
