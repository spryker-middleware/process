<?php

namespace SprykerMiddleware\Zed\Process\Business\Mapper\Map;

use Generated\Shared\Transfer\MapperConfigTransfer;

abstract class AbstractMap implements MapInterface
{
    /**
     * @var string
     */
    protected $preGeneratedMapPath;

    /**
     * @param string $preGeneratedMapPath
     */
    public function __construct(string $preGeneratedMapPath = '')
    {
        $this->preGeneratedMapPath = $preGeneratedMapPath;
    }

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
    protected function readMapFromFile(): array
    {
        return ($this->preGeneratedMapPath != '') ? json_decode(file_get_contents($this->preGeneratedMapPath), true) : [];
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
