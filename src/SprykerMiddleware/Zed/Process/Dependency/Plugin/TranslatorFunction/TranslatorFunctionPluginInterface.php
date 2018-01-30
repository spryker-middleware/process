<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction;

interface TranslatorFunctionPluginInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getTranslatorFunctionClassName();

    /**
     * @param mixed $value
     * @param string $key
     * @param array $options
     *
     * @return mixed
     */
    public function translate($value, string $key, array $options);
}
