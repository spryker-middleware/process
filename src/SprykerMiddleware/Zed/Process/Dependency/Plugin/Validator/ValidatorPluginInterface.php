<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator;

interface ValidatorPluginInterface
{
    /**
     * @api
     *
     * @return string
     */
    public function getName(): string;

    /**
     * @api
     *
     * @param mixed $value
     * @param array $payload
     * @param string $key
     * @param array $options
     *
     * @return bool
     */
    public function validate($value, array $payload, string $key, array $options): bool;
}
