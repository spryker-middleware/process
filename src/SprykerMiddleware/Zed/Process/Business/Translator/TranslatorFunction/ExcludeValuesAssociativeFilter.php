<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class ExcludeValuesAssociativeFilter extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    public const OPTION_EXCLUDE_VALUES = 'excludeValues';

    /**
     * @var array
     */
    protected $requiredOptions = [
        self::OPTION_EXCLUDE_VALUES,
    ];

    /**
     * @param array $value
     * @param array $payload
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return array
     */
    public function translate($value, array $payload): array
    {
        if (!is_array($value)) {
            throw new WrongTypeValueTranslatorException(static::class, $this->key, 'array', $value);
        }

        return array_diff($value, $this->options[self::OPTION_EXCLUDE_VALUES]);
    }
}
