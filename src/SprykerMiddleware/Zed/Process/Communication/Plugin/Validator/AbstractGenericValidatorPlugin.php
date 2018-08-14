<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Validator;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\GenericValidatorPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
abstract class AbstractGenericValidatorPlugin extends AbstractPlugin implements GenericValidatorPluginInterface
{
    /**
     * @return string
     */
    abstract public function getValidatorClassName(): string;

    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @param mixed $value
     * @param array $payload
     * @param string $key
     * @param array $options
     *
     * @return bool
     */
    public function validate($value, array $payload, string $key, array $options): bool
    {
        $validator = $this->getFactory()
            ->createValidatorFactory()
            ->createValidator($this->getValidatorClassName());
        $validator->setKey($key);
        $validator->setOptions($options);

        return $validator->validate($value, $payload);
    }
}
