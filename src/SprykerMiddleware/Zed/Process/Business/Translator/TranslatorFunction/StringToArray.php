<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */
namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class StringToArray extends AbstractTranslatorFunction
{
    public const OPTION_DELIMITER = 'delimiter';

    /**
     * @var array
     */
    protected $requiredOptions = [
        self::OPTION_DELIMITER,
    ];

    /**
     * @param string $value
     * @param array $payload
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return array
     */
    public function translate($value, array $payload): array
    {
        if (!is_string($value)) {
            throw new WrongTypeValueTranslatorException(static::class, $this->key, 'string', $value);
        }

        return explode($this->options[self::OPTION_DELIMITER], $value);
    }
}
