<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
