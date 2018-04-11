<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Stream;

use Codeception\Test\Unit;
use SprykerMiddlewareTest\Zed\Process\StreamMocks;

/**
 * @group SprykerMiddlewareTest
 * @group Zed
 * @group Process
 * @group Business
 * @group Stream
 * @group CsvReadStreamTest
 */
class StreamTest extends Unit
{
    use StreamMocks;

    const VALUE_CSV_ARRAY = [
        0 => [
            0 => 'Row11',
            1 => 'Row12',
            2 => 'Row13',
        ],
        1 => [
            0 => 'Row21',
            1 => 'Row22',
            2 => 'Row23',
        ],
    ];

    const PATH_CSV = '/tmp/csv_write_stream.csv';

    /**
     * @return void
     */
    public function testCsvReadStream(): void
    {
        $stream = $this->getCsvReadStream();

        $this->assertEquals($stream->open(), true);
        $this->assertEquals($stream->eof(), false);
        $this->assertEquals($stream->read(), self::VALUE_CSV_ARRAY[0]);
        $this->assertEquals($stream->eof(), false);
        $this->assertEquals($stream->read(), self::VALUE_CSV_ARRAY[1]);
        $this->assertEquals($stream->read(), null);
        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->seek(-1, SEEK_END), 0);
        $this->assertEquals($stream->read(), [0 => '3']);
        $this->assertEquals($stream->close(), true);
    }

    /**
     * @return void
     */
    public function testCsvWriteStream(): void
    {
        $stream = $this->getCsvWriteStream(self::PATH_CSV);

        $this->assertEquals($stream->open(), true);
        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->write(self::VALUE_CSV_ARRAY[0]), true);
        $this->assertEquals($stream->write(self::VALUE_CSV_ARRAY[1]), true);
        $this->assertEquals($stream->seek(1, SEEK_SET), true);
        $this->assertEquals($stream->flush(), true);
        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->close(), true);

        unlink(self::PATH_CSV);
    }


}
