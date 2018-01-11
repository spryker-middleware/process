<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\Dictionary;

use Generated\Shared\Transfer\TranslatorConfigTransfer;

abstract class AbstractDictionary implements DictionaryInterface
{
    /**
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    public function getTranslatorConfig(): TranslatorConfigTransfer
    {
        $translatorConfigTransfer = new TranslatorConfigTransfer();
        $translatorConfigTransfer->setDictionary($this->getDictionary());

        return $translatorConfigTransfer;
    }

    /**
     * @param string $dictionaryFilePath
     *
     * @return array
     */
    protected function readDictionaryFromFile(string $dictionaryFilePath): array
    {
        return json_decode(file_get_contents($dictionaryFilePath), true);
    }

    /**
     * @return array
     */
    abstract public function getDictionary(): array;
}
