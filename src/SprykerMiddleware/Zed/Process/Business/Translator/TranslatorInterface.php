<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator;

use Generated\Shared\Transfer\TranslatorConfigTransfer;

interface TranslatorInterface
{
    /**
     * @param array $payload
     * @param \Generated\Shared\Transfer\TranslatorConfigTransfer $translatorConfigTransfer
     *
     * @return array
     */
    public function translate(array $payload, TranslatorConfigTransfer $translatorConfigTransfer): array;
}
