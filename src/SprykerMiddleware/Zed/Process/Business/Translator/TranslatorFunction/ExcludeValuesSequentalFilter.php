<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class ExcludeValuesSequentalFilter extends ExcludeValuesAssociativeFilter
{
    /**
     * @param array $value
     *
     * @return array
     */
    public function translate($value)
    {
        return array_values(parent::translate($value));
    }
}
