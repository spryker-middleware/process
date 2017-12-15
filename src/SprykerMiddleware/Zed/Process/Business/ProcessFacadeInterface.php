<?php

namespace SprykerMiddleware\Zed\Process\Business;

use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;

interface ProcessFacadeInterface
{
    /**
     * @param array $payload
     * @param \SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface $map
     *
     * @return array
     */
    public function map(array $payload, MapInterface $map);

    /**
     * @param array $payload
     * @param array $dictionary
     *
     * @return array
     */
    public function translate(array $payload, array $dictionary);

    /**
     * @param array $payload
     * @param string $destination
     *
     * @return array
     */
    public function writeSerialized(array $payload, string $destination);

    /**
     * @param array $payload
     * @param string $destination
     *
     * @return array
     */
    public function writeJson(array $payload, string $destination);
}
