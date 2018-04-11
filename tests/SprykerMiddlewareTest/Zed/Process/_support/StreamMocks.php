<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Stream\CsvReadStream;
use SprykerMiddleware\Zed\Process\Business\Stream\CsvWriteStream;

trait StreamMocks
{
    protected function getCsvReadStream(): CsvReadStream
    {
        return new CsvReadStream(__DIR__ . '/stream/files/csv_read_stream_test.csv');
    }

    protected function getCsvWriteStream(string $path): CsvWriteStream
    {
        return new CsvWriteStream($path);
    }
}
