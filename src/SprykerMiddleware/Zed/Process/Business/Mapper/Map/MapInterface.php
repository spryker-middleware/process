<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper\Map;

use Generated\Shared\Transfer\MapperConfigTransfer;

interface MapInterface
{
    public const MAPPER_STRATEGY_COPY_UNKNOWN = 'MAPPER_STRATEGY_COPY_UNKNOWN';
    public const MAPPER_STRATEGY_SKIP_UNKNOWN = 'MAPPER_STRATEGY_SKIP_UNKNOWN';

    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    public function getMapperConfig(): MapperConfigTransfer;
}
