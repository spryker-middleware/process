<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Generated\Shared\Transfer\ProcessSettingsTransfer;
use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Generated\Shared\Transfer\ValidatorConfigTransfer;
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
            ->createPayloadMapper()
            ->map($payload, $mapperConfigTransfer);
    }

    /**
     * @api
     *
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $value
     * @param string $strategy
     *
     * @return array
     */
    public function mapByKey(array $result, array $payload, string $key, $value, string $strategy): array
    {
        return $this->getFactory()
            ->createKeyMapper()
            ->map($result, $payload, $key, $value, $strategy);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $value
     * @param string $strategy
     *
     * @return array
     */
    public function mapByClosure(array $result, array $payload, string $key, $value, string $strategy): array
    {
        return $this->getFactory()
            ->createClosureMapper()
            ->map($result, $payload, $key, $value, $strategy);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $value
     * @param string $strategy
     *
     * @return array
     */
    public function mapByArray(array $result, array $payload, string $key, $value, string $strategy): array
    {
        return $this->getFactory()
            ->createArrayMapper()
            ->map($result, $payload, $key, $value, $strategy);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $value
     * @param string $strategy
     *
     * @return array
     */
    public function mapByDynamic(array $result, array $payload, string $key, $value, string $strategy): array
    {
        return $this->getFactory()
            ->createDynamicMapper()
            ->map($result, $payload, $key, $value, $strategy);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $value
     * @param string $strategy
     *
     * @return array
     */
    public function mapByDynamicArray(array $result, array $payload, string $key, $value, string $strategy): array
    {
        return $this->getFactory()
            ->createDynamicArrayMapper()
            ->map($result, $payload, $key, $value, $strategy);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param array $payload
     * @param \Generated\Shared\Transfer\TranslatorConfigTransfer $translatorConfigTransfer
     *
     * @return array
     */
    public function translate(array $payload, TranslatorConfigTransfer $translatorConfigTransfer): array
    {
        return $this->getFactory()
            ->createTranslator()
            ->translate($payload, $translatorConfigTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer $processSettingsTransfer
     *
     * @return void
     */
    public function process(ProcessSettingsTransfer $processSettingsTransfer): void
    {
         $this->getFactory()
            ->createProcessor($processSettingsTransfer)
            ->process();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param array $payload
     * @param \Generated\Shared\Transfer\ValidatorConfigTransfer $validatorConfigTransfer
     *
     * @return array
     */
    public function validate(array $payload, ValidatorConfigTransfer $validatorConfigTransfer): array
    {
        return $this->getFactory()
            ->createPayloadValidator()
            ->validate($payload, $validatorConfigTransfer);
    }
}
