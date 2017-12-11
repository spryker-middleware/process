<?php

namespace SprykerMiddleware\Zed\Process\Business\Mapper;

interface MapperInterface
{
    /**
     * @param array $payload
     *
     * @return array
     */
    public function map(array $payload): array;
}
