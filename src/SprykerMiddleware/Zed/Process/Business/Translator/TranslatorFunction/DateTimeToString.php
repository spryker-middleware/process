<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use DateTime;
use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class DateTimeToString extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    public const FORMAT = 'format';
    /**
     * @var array
     */
    protected $requiredOptions = [
        self::FORMAT,
    ];

    /**
     * @param \DateTime $value
     * @param array $payload
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return string
     */
    public function translate($value, array $payload): string
    {
        if (!($value instanceof DateTime)) {
            throw new WrongTypeValueTranslatorException(static::class, $this->key, '\DateTime', $value);
        }

        return $value->format($this->options[static::FORMAT]);
    }
}
