<?php

/**
 * MIT License 
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerMiddlewareTest\Zed\Process\Business\Stream;

use Codeception\Test\Unit;
use SprykerMiddleware\Zed\Process\Business\Stream\StreamFactory;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyDecoderAdapter;
use SprykerMiddleware\Zed\Process\Dependency\External\ProcessToSymfonyEncoderAdapter;

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
    /** @var \SprykerMiddleware\Zed\Process\Business\Stream\StreamFactory */
    protected $factory;

    protected const VALUE_TEST_ARRAY = [
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

    protected const FILE_CSV_WRITE = '/tmp/csv_write_stream.csv';
    protected const FILE_JSON_WRITE = '/tmp/json_write_stream.json';
    protected const FILE_XML_WRITE = '/tmp/xml_write_stream.xml';

    protected const PATH_SUPPORT_STREAM_FILES = __DIR__ . '/../../_support/stream/files/';

    /**
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->factory = new StreamFactory();
    }

    /**
     * @return void
     */
    public function testCsvReadStream(): void
    {
        $stream = $this->factory->createCsvReadStream(static::PATH_SUPPORT_STREAM_FILES . 'csv_read_stream_test.csv');

        $this->assertEquals($stream->open(), true);
        $this->assertEquals($stream->eof(), false);
        $this->assertEquals($stream->read(), static::VALUE_TEST_ARRAY[0]);
        $this->assertEquals($stream->eof(), false);
        $this->assertEquals($stream->read(), static::VALUE_TEST_ARRAY[1]);
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
        $stream = $this->factory->createCsvWriteStream(static::FILE_CSV_WRITE);

        $this->assertEquals($stream->open(), true);
        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->write(static::VALUE_TEST_ARRAY[0]), true);
        $this->assertEquals($stream->write(static::VALUE_TEST_ARRAY[1]), true);
        $this->assertEquals($stream->seek(1, SEEK_SET), true);
        $this->assertEquals($stream->flush(), true);
        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->close(), true);

        unlink(static::FILE_CSV_WRITE);
    }

    /**
     * @return void
     */
    public function testDirectoryStream(): void
    {
        $stream = $this->factory->createDirectoryStream(static::PATH_SUPPORT_STREAM_FILES);

        $this->assertEquals($stream->open(), true);
        $this->assertEquals($stream->eof(), false);
        $this->assertEquals($stream->seek(3, SEEK_SET), true);
        $this->assertTrue(!is_string($stream->read()));
        $this->assertTrue((bool)$stream->seek(0, SEEK_SET));
        $this->assertTrue(is_string($stream->read()), true);
        $this->assertTrue($stream->close(), true);
    }

    /**
     * @return void
     */
    public function testJsonReadStream(): void
    {
        $stream = $this->factory->createJsonReadStream(static::PATH_SUPPORT_STREAM_FILES . 'json_read_stream_test.json');

        $this->assertEquals($stream->open(), true);
        $this->assertEquals($stream->eof(), false);

        if (!$stream->eof()) {
            $this->assertEquals(is_array($stream->read()), true);
            $this->assertEquals($stream->seek(0, SEEK_END), true);
        }

        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->close(), true);
    }

    /**
     * @return void
     */
    public function testJsonWriteStream(): void
    {
        $stream = $this->factory->createJsonWriteStream(static::FILE_JSON_WRITE);

        $this->assertEquals($stream->open(), true);
        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->write(static::VALUE_TEST_ARRAY[0]), true);
        $this->assertEquals($stream->write(static::VALUE_TEST_ARRAY[1]), true);
        $this->assertEquals($stream->seek(1, SEEK_SET), true);
        $this->assertEquals($stream->flush(), true);
        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->close(), true);

        unlink(static::FILE_JSON_WRITE);
    }

    /**
     * @return void
     */
    public function testXmlReadStream(): void
    {
        $stream = $this->factory->createXmlReadStream(static::PATH_SUPPORT_STREAM_FILES . 'xml_read_stream_test.xml', 'food', new ProcessToSymfonyDecoderAdapter());

        $this->assertEquals($stream->open(), true);
        $this->assertEquals($stream->eof(), false);
        $this->assertEquals($stream->seek(0, 0), -1);

        while (!$stream->eof()) {
            $this->assertEquals(is_array($stream->read()), true);
        }

        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->close(), true);
    }

    /**
     * @return void
     */
    public function testXmlWriteStream(): void
    {
        $stream = $this->factory->createXmlWriteStream(
            static::FILE_XML_WRITE,
            'breakfast_menu',
            'food',
            new ProcessToSymfonyEncoderAdapter()
        );

        $this->assertEquals($stream->open(), true);
        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->write(static::VALUE_TEST_ARRAY[0]), true);
        $this->assertEquals($stream->write(static::VALUE_TEST_ARRAY[1]), true);
        $this->assertEquals($stream->seek(1, SEEK_SET), true);
        $this->assertEquals($stream->flush(), true);
        $this->assertEquals($stream->eof(), true);
        $this->assertEquals($stream->close(), true);

        unlink(static::FILE_XML_WRITE);
    }
}
