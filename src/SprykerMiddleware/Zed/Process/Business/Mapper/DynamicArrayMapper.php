<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper;

use Generated\Shared\Transfer\MapperConfigTransfer;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface;
use SprykerMiddleware\Zed\Process\Business\Mapper\Payload\PayloadMapperInterface;

class DynamicArrayMapper extends AbstractMapper
{
    /**
     * @var \SprykerMiddleware\Zed\Process\Business\Mapper\Payload\PayloadMapperInterface
     */
    protected $payloadMapper;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface $arrayManager
     * @param \SprykerMiddleware\Zed\Process\Business\Mapper\Payload\PayloadMapperInterface $payloadMapper
     */
    public function __construct(ArrayManagerInterface $arrayManager, PayloadMapperInterface $payloadMapper)
    {
        parent::__construct($arrayManager);
        $this->payloadMapper = $payloadMapper;
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $value
     * @param string $strategy
     *
     * @return array
     */
    public function map(array $result, array $payload, string $key, $value, string $strategy): array
    {
        $originKey = reset($value);
        $originArray = $this->arrayManager->getValueByKey($payload, $originKey);
        $resultArray = $originArray;

        if (is_array($originArray) && isset($value[static::OPTION_DYNAMIC_ITEM_MAP])) {
            $resultArray = [];
            $rules = $value[static::OPTION_DYNAMIC_ITEM_MAP];
            $mapperConfig = (new MapperConfigTransfer())
                ->setStrategy($strategy)
                ->setMap($rules);
            foreach ($originArray as $originItemKey => $item) {
                $resultItem = $item;
                foreach ($rules as $itemKey => $itemValue) {
                    $resultItem = $this->payloadMapper->map($item, $mapperConfig);
                }
                $resultArray = array_merge($resultArray, $resultItem);
            }
        }

        $this->log(static::OPERATION, static::OPERATION_MAP_DYNAMIC_ARRAY, $key, $value, $resultArray);

        return $this->arrayManager->putValue($result, $key, $resultArray);
    }
}
