<?php

namespace SprykerMiddleware\Zed\Process\Business;

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
     *
     * @return array
     */
    public function translate(array $payload, array $dictionary)
    {
        return $this->getFactory()
            ->createTranslator($dictionary)
            ->translate($payload);
    }
}
