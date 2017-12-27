<?php

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
     * @return array
     */
    abstract protected function getMap(): array;

    /**
     * @return string
     */
    abstract protected function getStrategy(): string;
}
