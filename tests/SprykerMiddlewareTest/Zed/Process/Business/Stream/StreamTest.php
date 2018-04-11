<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Stream;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Stream\StreamFactory;
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

    const FILE_CSV_WRITE = '/tmp/csv_write_stream.csv';

    const PATH_SUPPORT_STREAM_FILES =  __DIR__ . '/../../_support/stream/files/';

    /**
     * @return void
     */
    public function testCsvReadStream(): void
    {
        $stream = $this->getCsvReadStream(self::PATH_SUPPORT_STREAM_FILES . 'csv_read_stream_test.csv');

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
        $stream = $this->getCsvWriteStream(self::FILE_CSV_WRITE);

        $this->assertEquals($stream->open(), true);
        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->write(self::VALUE_CSV_ARRAY[0]), true);
        $this->assertEquals($stream->write(self::VALUE_CSV_ARRAY[1]), true);
        $this->assertEquals($stream->seek(1, SEEK_SET), true);
        $this->assertEquals($stream->flush(), true);
        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->close(), true);

        unlink(self::FILE_CSV_WRITE);
    }

    /**
     * @return void
     */
    public function testDirectoryStream(): void
    {
        $stream = $this->getDirectoryStream(self::PATH_SUPPORT_STREAM_FILES);

        $this->assertEquals($stream->open(), true);
        $this->assertEquals($stream->eof(), false);
        $this->assertEquals($stream->seek(1, SEEK_SET), true);
        $this->assertTrue(!is_string($stream->read()));
        $this->assertTrue((bool) $stream->seek(0, SEEK_SET));
        $this->assertTrue(is_string($stream->read()), true);
        $this->assertTrue($stream->close(), true);
    }

    public function testJsonReadStream(): void
    {

    }

    public function testJsonWriteStream(): void
    {

    }

    public function testXmlReadStream(): void
    {

    }


    public function testXmlWriteStream(): void
    {

    }
}
