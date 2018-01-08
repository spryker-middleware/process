<?php

namespace SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException;

class WhitelistKeysAssociativeFilter extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    const OPTION_WHITELIST_KEYS = 'whitelistKeys';
    /**
     * @var array
     */
    protected $requiredOptions = [
        self::OPTION_WHITELIST_KEYS,
    ];

    /**
     * @param array $value
     *
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\WrongTypeValueTranslatorException
     *
     * @return array
     */
    public function translate($value)
    {
        if (!is_array($value)) {
            throw new WrongTypeValueTranslatorException();
        }

        return array_intersect_key($value, array_flip($this->options[self::OPTION_WHITELIST_KEYS]));
    }
}
