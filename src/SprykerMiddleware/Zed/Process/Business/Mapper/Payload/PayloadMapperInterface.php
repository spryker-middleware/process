<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper\Payload;

use Generated\Shared\Transfer\MapperConfigTransfer;

interface PayloadMapperInterface
{
    /**
     * @param array $payload
     * @param \Generated\Shared\Transfer\MapperConfigTransfer $mapperConfigTransfer
     *
     * @return array
     */
    public function map(array $payload, MapperConfigTransfer $mapperConfigTransfer): array;
}
