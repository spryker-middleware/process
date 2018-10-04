<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
