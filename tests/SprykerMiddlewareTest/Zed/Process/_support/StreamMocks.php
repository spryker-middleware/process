<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Stream\CsvReadStream;
use SprykerMiddleware\Zed\Process\Business\Stream\CsvWriteStream;
use SprykerMiddleware\Zed\Process\Business\Stream\DirectoryStream;
use SprykerMiddleware\Zed\Process\Business\Stream\JsonReadStream;

trait StreamMocks
{
    protected function getCsvReadStream(string $path): CsvReadStream
    {
        return new CsvReadStream($path);
    }

    protected function getCsvWriteStream(string $path): CsvWriteStream
    {
        return new CsvWriteStream($path);
    }

    protected function getDirectoryStream(string $path): DirectoryStream
    {
        return new DirectoryStream($path);
    }

    protected function getJsonReadStream(string $path): JsonReadStream
    {
        return new JsonReadStream($path);
    }
}
