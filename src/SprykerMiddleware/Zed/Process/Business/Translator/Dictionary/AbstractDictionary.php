<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

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
