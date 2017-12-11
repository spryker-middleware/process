<?php

namespace SprykerMiddleware\Zed\Process\Business;

interface ProcessFacadeInterface
{
    /**
     * @param array $payload
     * @param array $map
     *
     * @return array
     */
    public function map(array $payload, array $map);
}
