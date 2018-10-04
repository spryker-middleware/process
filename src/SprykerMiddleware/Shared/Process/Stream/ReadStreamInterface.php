<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Shared\Process\Stream;

interface ReadStreamInterface extends StreamInterface
{
    public const STATUS_SEEK_SUCCESS = 1;
    public const STATUS_SEEK_FAIL = 0;

    /**
     * @return mixed
     */
    public function read();
}
