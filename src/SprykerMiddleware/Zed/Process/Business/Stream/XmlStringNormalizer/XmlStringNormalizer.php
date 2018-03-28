<?php

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
