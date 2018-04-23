<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper\Payload;

use Generated\Shared\Transfer\MapperConfigTransfer;
use SprykerMiddleware\Shared\Logger\Logger\MiddlewareLoggerTrait;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface;
use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;

class PayloadMapper implements PayloadMapperInterface
{
    use MiddlewareLoggerTrait;

    protected const OPERATION = 'Mapping';
    protected const OPERATION_COPY_ORIGINAL_DATA = 'Copy original data';
    protected const OPERATION_MAP_ARRAY = 'Map array';
    protected const OPERATION_MAP_CALLABLE = 'Map callable';
    protected const OPERATION_MAP_KEY = 'Map key';
    protected const OPERATION_SELF_REFERENCED_KEY = 'Map self referenced key';

    protected const KEY_DATA = 'data';
    protected const KEY_NEW_KEY = 'new_key';
    protected const KEY_OLD_KEY = 'old_key';
    protected const KEY_OPERATION = 'operation';
    protected const KEY_STRATEGY = 'strategy';

    /**
     * @var \Generated\Shared\Transfer\MapperConfigTransfer
     */
    protected $mapperConfigTransfer;

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface
     */
    protected $arrayManager;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\MapRule\MapRulePluginInterface[]
     */
    protected $mapRulePlugins;

    /**
     * @param \Generated\Shared\Transfer\MapperConfigTransfer $mapperConfigTransfer
     * @param \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface $arrayManager
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\MapRule\MapRulePluginInterface[] $mapperPlugins
     */
    public function __construct(
        MapperConfigTransfer $mapperConfigTransfer,
        ArrayManagerInterface $arrayManager,
        array $mapperPlugins
    ) {
        $this->mapperConfigTransfer = $mapperConfigTransfer;
        $this->arrayManager = $arrayManager;
        $this->mapRulePlugins = $mapperPlugins;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    public function map(array $payload): array
    {
        $result = $this->prepareResult($payload);
        foreach ($this->mapperConfigTransfer->getMap() as $key => $value) {
            $result = $this->mapByRule($result, $payload, $key, $value);
        }

        return $result;
    }

    /**
     * @param array $result
     * @param array $payload
     * @param string $key
     * @param mixed $value
     *
     * @return array
     */
    protected function mapByRule(array $result, array $payload, string $key, $value): array
    {
        foreach ($this->mapRulePlugins as $rule) {
            if ($rule->isApplicable($key, $value)) {
                return $rule->map($result, $payload, $key, $value);
            }
        }

        return $result;
    }

    /**
     * @param array $payload
     *
     * @return array
     */
    protected function prepareResult(array $payload): array
    {
        if ($this->mapperConfigTransfer->getStrategy() === MapInterface::MAPPER_STRATEGY_COPY_UNKNOWN) {
            $this->getProcessLogger()->debug(static::OPERATION, [
                static::KEY_OPERATION => static::OPERATION_COPY_ORIGINAL_DATA,
                static::KEY_STRATEGY => $this->mapperConfigTransfer->getStrategy(),
            ]);
            return $payload;
        }

        return [];
    }
}
