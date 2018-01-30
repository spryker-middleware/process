<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper\Map;

use Generated\Shared\Transfer\MapperConfigTransfer;

abstract class AbstractMap implements MapInterface
{
    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    public function getMapperConfig(): MapperConfigTransfer
    {
        $mapperConfigTransfer = new MapperConfigTransfer();
        $mapperConfigTransfer->setMap($this->getMap());
        $mapperConfigTransfer->setStrategy($this->getStrategy());

        return $mapperConfigTransfer;
    }

    /**
     * @param string $mapFilePath
     *
     * @return array
     */
    protected function readMapFromFile(string $mapFilePath): array
    {
        return json_decode(file_get_contents($mapFilePath), true);
    }

    /**
     * @return array
     */
    abstract protected function getMap(): array;

    /**
     * @return string
     */
    abstract protected function getStrategy(): string;
}
