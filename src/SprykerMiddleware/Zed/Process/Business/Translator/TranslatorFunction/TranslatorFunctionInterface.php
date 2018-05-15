<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

interface TranslatorFunctionInterface
{
    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return mixed
     */
    public function translate($value, array $payload);

    /**
     * @param array $options
     *
     * @return void
     */
    public function setOptions(array $options): void;

    /**
     * @param string $key
     *
     * @return void
     */
    public function setKey(string $key): void;
}
