<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Mapper;

use SprykerMiddleware\Shared\Logger\Logger\MiddlewareLoggerTrait;
use SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface;

abstract class AbstractMapper implements MapperInterface
{
    use MiddlewareLoggerTrait;

    protected const OPERATION = 'Mapping';
    protected const OPERATION_COPY_ORIGINAL_DATA = 'Copy original data';
    protected const OPERATION_MAP_ARRAY = 'Map array';
    protected const OPERATION_MAP_CALLABLE = 'Map callable';
    protected const OPERATION_MAP_KEY = 'Map key';
    protected const OPERATION_MAP_DYNAMIC = 'Map dynamic';
    protected const OPERATION_MAP_DYNAMIC_ARRAY = 'Map dynamic';

    protected const KEY_DATA = 'data';
    protected const KEY_NEW_KEY = 'new_key';
    protected const KEY_OLD_KEY = 'old_key';
    protected const KEY_OPERATION = 'operation';
    protected const KEY_STRATEGY = 'strategy';

    public const OPTION_ITEM_MAP = 'itemMap';
    public const OPTION_DYNAMIC_ITEM_MAP = 'dynamicItemMap';
    public const OPTION_DYNAMIC_IDENTIFIER = '&';

    /**
     * @var \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface
     */
    protected $arrayManager;

    /**
     * @param \SprykerMiddleware\Zed\Process\Business\ArrayManager\ArrayManagerInterface $arrayManager
     */
    public function __construct(ArrayManagerInterface $arrayManager)
    {
        $this->arrayManager = $arrayManager;
    }

    /**
     * @param string $operationType
     * @param string $operationKey
     * @param mixed $newKey
     * @param mixed $oldKey
     * @param mixed $data
     *
     * @return void
     */
    protected function log(string $operationType, string $operationKey, $newKey, $oldKey, $data): void
    {
        $this->getProcessLogger()->debug($operationType, [
            static::KEY_OPERATION => $operationKey,
            static::KEY_NEW_KEY => $newKey,
            static::KEY_OLD_KEY => $oldKey,
            static::KEY_DATA => $data,
        ]);
    }
}
