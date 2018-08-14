<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

interface ValidatorInterface
{
    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return bool
     */
    public function validate($value, array $payload): bool;

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options);

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key);
}
