<?php

namespace SprykerMiddleware\Zed\Process\Business\Mapper\Map;

interface MapInterface
{
    /**
     * @return array
     */
    public function getMap(): array;

    /**
     * @return string
     */
    public function getStrategy(): string;
}
