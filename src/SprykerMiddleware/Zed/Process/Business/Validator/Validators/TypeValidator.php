<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class TypeValidator extends AbstractValidator
{
    public const OPTION_TYPE = 'type';

    /**
     * @var array
     */
    protected $requiredOptions = [self::OPTION_TYPE];

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return bool
     */
    public function validate($value, array $payload): bool
    {
        if ($value === null) {
            return true;
        }

        $type = strtolower($this->getType());
        $type = $type == 'boolean' ? 'bool' : $type;
        $isFunction = 'is_' . $type;
        $ctypeFunction = 'ctype_' . $type;

        if (function_exists($isFunction) && $isFunction($value)) {
            return true;
        }

        if (function_exists($ctypeFunction) && $ctypeFunction($value)) {
            return true;
        }

        $type = $this->getType();
        if ($value instanceof $type) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    protected function getType()
    {
        return $this->options[static::OPTION_TYPE];
    }
}
