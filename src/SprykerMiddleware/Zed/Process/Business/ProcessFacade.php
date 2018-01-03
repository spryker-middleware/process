<?php

namespace SprykerMiddleware\Zed\Process\Business;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessBusinessFactory getFactory()
 */
class ProcessFacade extends AbstractFacade implements ProcessFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param array $payload
     * @param \Generated\Shared\Transfer\MapperConfigTransfer $mapperConfigTransfer
     *
     * @return array
     */
    public function map(array $payload, MapperConfigTransfer $mapperConfigTransfer): array
    {
        return $this->getFactory()
            ->createMapper($mapperConfigTransfer)
            ->map($payload);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param array $payload
     * @param \Generated\Shared\Transfer\TranslatorConfigTransfer $translatorConfigTransfer
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return array
     */
    public function translate(array $payload, TranslatorConfigTransfer $translatorConfigTransfer): array
    {
        return $this->getFactory()
            ->createTranslator($translatorConfigTransfer)
            ->translate($payload);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer $processSettingsTransfer
     * @param resource $inStream
     * @param resource $outStream
     *
     * @return void
     */
    public function process(ProcessSettingsTransfer $processSettingsTransfer, $inStream, $outStream): void
    {
         $this->getFactory()
            ->createProcessor($processSettingsTransfer, $inStream, $outStream)
            ->process();
    }

    /**
     * @param resource $inStream
     *
     * @return array
     */
    public function readJson($inStream): array
    {
        return $this->getFactory()
            ->createJsonReader()
            ->read($inStream);
    }

    /**
     * @param resource $outStream
     * @param array $payload
     *
     * @return array
     */
    public function writeJson($outStream, $payload)
    {
        return $this->getFactory()
            ->createJsonWriter()
            ->write($outStream, $payload);
    }
}
