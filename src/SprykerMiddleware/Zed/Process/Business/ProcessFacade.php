<?php

namespace SprykerMiddleware\Zed\Process\Business;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Psr\Log\LoggerInterface;
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
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return array
     */
    public function map(array $payload, MapperConfigTransfer $mapperConfigTransfer, LoggerInterface $logger): array
    {
        return $this->getFactory()
            ->createMapper($mapperConfigTransfer, $logger)
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
    public function translate(array $payload, TranslatorConfigTransfer $translatorConfigTransfer, LoggerInterface $logger): array
    {
        return $this->getFactory()
            ->createTranslator($translatorConfigTransfer, $logger)
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
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return array
     */
    public function readJson($inStream, LoggerInterface $logger): array
    {
        return $this->getFactory()
            ->createJsonReader($logger)
            ->read($inStream);
    }

    /**
     * @param resource $outStream
     * @param array $payload
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return array
     */
    public function writeJson($outStream, $payload, $logger)
    {
        return $this->getFactory()
            ->createJsonWriter($logger)
            ->write($outStream, $payload);
    }
}
