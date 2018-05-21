<?php
namespace MoReader\Tests;

use MoReader\Reader;

/**
 *
 */
class MoReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     *
     */
    public function setUp()
    {
        $this->reader = new Reader();
    }

    /**
     *
     */
    public function testGeneral()
    {
        $entries = $this->reader->load(TEST_DATA_PATH . '/general.mo');

        $correctData = array(
            array('', ''),
            array('cat', 'gato'),
            array('dog', 'perro')
        );

        $this->assertEquals(count($correctData), count($entries));

        $idx = 0;
        foreach ($entries as $entryKey => $entryValue) {
            if ($correctData[$idx][0] !== '') {
                $this->assertEquals($correctData[$idx][0], $entryKey);
                $this->assertEquals($correctData[$idx][1], $entryValue);
            }
            $idx++;
        }
    }

    /**
     * Test loading a file with wrong major revision
     */
    public function testLoadingFileWithWrongRevision()
    {
        $this->setExpectedException(
            'Exception',
            ' has an unknown major revision'
        );
        $this->reader->load(TEST_DATA_PATH . '/invalid-major-revision.mo');
    }

    /**
     * Test loading not existing file throws exception
     */
    public function testLoadingNotExistingFileThrowsException()
    {
        $this->setExpectedException(
            'Exception',
            'File foobar does not exist'
        );

        $this->reader->load('foobar');
    }

    /**
     * Test loading an invalid gettext file throws exception
     */
    public function testLoadingAnInvalidGettextFileThrowsException()
    {
        $this->setExpectedException(
            'Exception',
            ' is not a valid gettext file'
        );

        $this->reader->load(TEST_DATA_PATH . '/invalid.mo');
    }
}
