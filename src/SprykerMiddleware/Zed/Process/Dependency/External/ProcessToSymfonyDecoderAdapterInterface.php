<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\External;

interface ProcessToSymfonyDecoderAdapterInterface
{
    /**
     * @param string $data
     * @param string $format
     *
     * @return array
     */
    public function decode(string $data, string $format): array;
}
