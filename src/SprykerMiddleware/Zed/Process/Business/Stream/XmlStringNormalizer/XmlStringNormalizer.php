<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddleware\Zed\Process\Business\Stream\XmlStringNormalizer;

class XmlStringNormalizer implements XmlStringNormalizerInterface
{
    /**
     * @param string $xmlString
     *
     * @return string
     */
    public function normalizeXmlString(string $xmlString): string
    {
        return preg_replace('/<\?xml.*\?\>/', '', $xmlString);
    }
}
