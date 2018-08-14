<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
