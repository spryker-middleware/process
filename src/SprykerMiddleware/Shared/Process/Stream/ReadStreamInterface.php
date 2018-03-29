<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Shared\Process\Stream;

interface ReadStreamInterface extends StreamInterface
{
    /**
     * @return mixed
     */
    public function read();
}
