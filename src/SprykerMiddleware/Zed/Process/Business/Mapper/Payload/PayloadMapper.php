<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @var \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface
     */
    protected $arrayManager;

    /**
     * @var \SprykerMiddleware\Zed\Process\Dependency\Plugin\MapRule\MapRulePluginInterface[]
     */
    protected $mapRulePlugins;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface $arrayManager
     * @param \SprykerMiddleware\Zed\Process\Dependency\Plugin\MapRule\MapRulePluginInterface[] $mapperPlugins
     */
    public function __construct(
        ArrayManagerInterface $arrayManager,
        array $mapperPlugins
    ) {
        $this->arrayManager = $arrayManager;
        $this->mapRulePlugins = $mapperPlugins;
    }

    /**
     * @param array $payload
     * @param \Generated\Shared\Transfer\MapperConfigTransfer $mapperConfigTransfer
     *
     * @return array
     */
    public function map(array $payload, MapperConfigTransfer $mapperConfigTransfer): array
    {
        $result = $this->prepareResult($payload, $mapperConfigTransfer);
        foreach ($mapperConfigTransfer->getMap() as $key => $value) {
            $result = $this->mapByRule($result, $payload, $key, $value, $mapperConfigTransfer->getStrategy());
        }

        return $result;
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
    protected function mapByRule(array $result, array $payload, string $key, $value, string $strategy): array
    {
        foreach ($this->mapRulePlugins as $rule) {
            if ($rule->isApplicable($key, $value)) {
                return $rule->map($result, $payload, $key, $value, $strategy);
            }
        }

        return $result;
    }

    /**
     * @param array $payload
     * @param \Generated\Shared\Transfer\MapperConfigTransfer $mapperConfigTransfer
     *
     * @return array
     */
    protected function prepareResult(array $payload, MapperConfigTransfer $mapperConfigTransfer): array
    {
        if ($mapperConfigTransfer->getStrategy() === MapInterface::MAPPER_STRATEGY_COPY_UNKNOWN) {
            $this->getProcessLogger()->debug(static::OPERATION, [
                static::KEY_OPERATION => static::OPERATION_COPY_ORIGINAL_DATA,
                static::KEY_STRATEGY => $mapperConfigTransfer->getStrategy(),
            ]);
            return $payload;
        }

        return [];
    }
}
