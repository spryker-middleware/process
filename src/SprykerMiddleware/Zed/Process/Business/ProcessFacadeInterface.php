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

interface ProcessFacadeInterface
{
    /**
     * Specification:
     * - Runs middleware process according to provided configuration.
     * - Reads data from input stream.
     * - Process each data item in pipeline.
     * - Writes result to output stream.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProcessSettingsTransfer $processSettingsTransfer $processSettingsTransfer
     *
     * @return void
     */
    public function process(ProcessSettingsTransfer $processSettingsTransfer): void;

    /**
     * Specification:
     * - Maps given payload using mapping rules that are specified in $mapperConfigTransfer
     *
     * @api
     *
     * @param array $payload
     * @param \Generated\Shared\Transfer\MapperConfigTransfer $mapperConfigTransfer
     *
     * @return array
     */
    public function map(array $payload, MapperConfigTransfer $mapperConfigTransfer): array;

    /**
     * Specification:
     * - Maps given payload by key.
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
    public function mapByKey(array $result, array $payload, string $key, $value, string $strategy): array;

    /**
     * Specification:
     * - Maps given payload by closure.
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
    public function mapByClosure(array $result, array $payload, string $key, $value, string $strategy): array;

    /**
     * Specification:
     * - Maps given payload as array with recursive calling.
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
    public function mapByArray(array $result, array $payload, string $key, $value, string $strategy): array;

    /**
     * Specification:
     * - Maps given payload by dynamic keys
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
    public function mapByDynamic(array $result, array $payload, string $key, $value, string $strategy): array;

    /**
     * Specification:
     * - Maps given payload as array with dynamic keys and recursive calling.
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
    public function mapByDynamicArray(array $result, array $payload, string $key, $value, string $strategy): array;

    /**
     * Specification:
     * - Translates given payload using dictionary that is specified in $translatorConfigTransfer
     *
     * @api
     *
     * @param array $payload
     * @param \Generated\Shared\Transfer\TranslatorConfigTransfer $translatorConfigTransfer
     *
     * @return array
     */
    public function translate(array $payload, TranslatorConfigTransfer $translatorConfigTransfer): array;

    /**
     * Specification:
     * - Validates given payload using validation rules that are specified in $validationConfigTransfer
     *
     * @api
     *
     * @param array $payload
     * @param \Generated\Shared\Transfer\ValidatorConfigTransfer $validationConfigTransfer
     *
     * @return array
     */
    public function validate(array $payload, ValidatorConfigTransfer $validationConfigTransfer): array;
}
