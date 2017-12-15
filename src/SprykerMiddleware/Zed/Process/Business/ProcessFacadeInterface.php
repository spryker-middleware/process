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
