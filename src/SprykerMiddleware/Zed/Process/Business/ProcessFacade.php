<?php

namespace SprykerMiddleware\Zed\Process\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessBusinessFactory getFactory()
 */
class ProcessFacade extends AbstractFacade implements ProcessFacadeInterface
{
    /**
     * @param array $payload
     * @param array $map
     *
     * @return array
     */
    public function map(array $payload, array $map)
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
