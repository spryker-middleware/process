<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

class Enum extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    public const OPTION_MAP = 'map';

    /**
     * @var array
     */
    protected $requiredOptions = [
        self::OPTION_MAP,
    ];

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return mixed
     */
    public function translate($value, array $payload)
    {
        if (is_array($this->options[self::OPTION_MAP]) && isset($this->options[self::OPTION_MAP][$value])) {
            return $this->options[self::OPTION_MAP][$value];
        }
    }
}
