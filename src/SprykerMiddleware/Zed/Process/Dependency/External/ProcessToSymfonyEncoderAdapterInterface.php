<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\External;

interface ProcessToSymfonyEncoderAdapterInterface
{
    /**
     * @param mixed $data
     * @param string $format
     * @param array $context
     *
     * @return mixed
     */
    public function encode($data, string $format, array $context);
}
