<?php

namespace SprykerMiddleware\Zed\Process\Business;

use Psr\Log\LoggerInterface;
use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;

interface ProcessFacadeInterface
{
    /**
     * @param array $payload
     * @param \SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface $map
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return array
     */
    public function map(array $payload, MapInterface $map, LoggerInterface $logger): array;

    /**
     * @param array $payload
     * @param array $dictionary
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return array
     */
    public function translate(array $payload, array $dictionary, LoggerInterface $logger): array;

    /**
     * @param array $payload
     * @param string $writerName
     * @param string $destination
     *
     * @return array
     */
    public function write(array $payload, string $writerName, string $destination): array;
}
