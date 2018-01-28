<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper\Map;

use Generated\Shared\Transfer\MapperConfigTransfer;

interface MapInterface
{
    /**
     * @return \Generated\Shared\Transfer\MaperConfig
     */
    public function getMapperConfig(): MapperConfigTransfer;
}
