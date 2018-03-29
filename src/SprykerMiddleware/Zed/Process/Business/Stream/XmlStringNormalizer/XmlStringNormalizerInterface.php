<?php

namespace SprykerMiddleware\Zed\Process\Business\Stream\XmlStringNormalizer;

interface XmlStringNormalizerInterface
{
    /**
     * @param string $xmlString
     *
     * @return string
     */
    public function normalizeXmlString(string $xmlString): string;
}
