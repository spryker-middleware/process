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
     * @return array
     */
    abstract public function getDictionary(): array;
}
