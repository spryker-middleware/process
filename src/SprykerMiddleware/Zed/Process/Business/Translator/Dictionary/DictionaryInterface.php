<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\Dictionary;

use Generated\Shared\Transfer\TranslatorConfigTransfer;

interface DictionaryInterface
{
    public const OPTIONS = 'options';

    /**
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    public function getTranslatorConfig(): TranslatorConfigTransfer;
}
