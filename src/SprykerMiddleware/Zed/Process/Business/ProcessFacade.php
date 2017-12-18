<?php

namespace SprykerMiddleware\Zed\Process\Business;

use Psr\Log\LoggerInterface;
use Spryker\Zed\Kernel\Business\AbstractFacade;
use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessBusinessFactory getFactory()
 */
class ProcessFacade extends AbstractFacade implements ProcessFacadeInterface
{
    /**
     * @param array $payload
     * @param \SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface $map
     *
     * @return array
     */
    public function map(array $payload, MapInterface $map)
    {
        return $this->getFactory()
            ->createMapper($map)
            ->map($payload);
    }

    /**
     * @param array $payload
     * @param array $dictionary
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return array
     */
    public function translate(array $payload, array $dictionary, LoggerInterface $logger)
    {
        return $this->getFactory()
            ->createTranslator($dictionary, $logger)
            ->translate($payload);
    }

    /**
     * @param array $payload
     * @param string $writerName
     * @param string $destination
     *
     * @return array
     */
    public function write(array $payload, string $writerName, string $destination)
    {
        return $this->getFactory()
            ->createWriter($writerName)
            ->write($payload, $destination);
    }
}
