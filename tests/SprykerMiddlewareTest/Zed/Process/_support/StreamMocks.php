<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Stream\CsvReadStream;

trait StreamMocks
{
    protected function getCsvStream(): CsvReadStream
    {
        return new CsvReadStream(__DIR__ . '/stream/files/csv_read_stream_test.csv');
    }
}
