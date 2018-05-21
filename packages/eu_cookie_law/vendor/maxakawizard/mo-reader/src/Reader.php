<?php

namespace MoReader;

/**
 * Gettext loader
 */
class Reader
{
    /**
     * Current file pointer.
     *
     * @var resource
     */
    protected $file;

    /**
     * @var string
     */
    protected $filename;

    /**
     * Whether the current file is little endian.
     *
     * @var bool
     */
    protected $littleEndian;

    /**
     * @var integer
     */
    protected $stringsCount;

    /**
     * @var array
     */
    protected $msgIdTable;

    /**
     * @var array
     */
    protected $msgStrTable;

    /**
     *
     * @param  string $filename
     * @return array
     * @throws \Exception
     */
    public function load($filename)
    {
        $this->openFile($filename);

        $this->determineByteOrder();
        $this->verifyMajorRevision();

        $this->readStringTables();

        $data = $this->readTranslations();

        fclose($this->file);

        return $data;
    }

    /**
     *
     */
    protected function readStringTables()
    {
        $this->stringsCount = $this->readInteger();
        $msgIdTableOffset = $this->readInteger();
        $msgStrTableOffset = $this->readInteger();

        // Usually there follow size and offset of the hash table, but we have
        // no need for it, so we skip them.
        fseek($this->file, $msgIdTableOffset);
        $this->msgIdTable = $this->readIntegerList(2 * $this->stringsCount);

        fseek($this->file, $msgStrTableOffset);
        $this->msgStrTable = $this->readIntegerList(2 * $this->stringsCount);
    }

    /**
     * @return array
     */
    protected function readTranslations()
    {
        $data = array();

        for ($counter = 0; $counter < $this->stringsCount; $counter++) {
            $msgId = $this->readMsgId($counter);
            $msgStr = $this->readTranslation($counter);

            $this->processRecord($data, $msgId, $msgStr);
        }

        return $data;
    }

    /**
     * @param $data
     * @param $msgId
     * @param $msgStr
     */
    protected function processRecord(&$data, $msgId, $msgStr)
    {
        if (count($msgId) > 1 && count($msgStr) > 1) {
            $data[$msgId[0]] = $msgStr;

            array_shift($msgId);

            foreach ($msgId as $string) {
                $data[$string] = '';
            }
        } else {
            $data[$msgId[0]] = $msgStr[0];
        }
    }

    /**
     * Reads specified message id record
     *
     * @param $index
     *
     * @return array
     */
    protected function readMsgId($index)
    {
        $msgId = $this->readStringFromTable($index, $this->msgIdTable);
        if (false === $msgId) {
            $msgId = array('');
        }

        return $msgId;
    }

    /**
     * Reads specified translation record
     *
     * @param integer $index
     *
     * @return array
     */
    protected function readTranslation($index)
    {
        $msgStr = $this->readStringFromTable($index, $this->msgStrTable);
        if (false === $msgStr) {
            $msgStr = array();
        }

        return $msgStr;
    }

    /**
     * @param $index
     * @param $table
     *
     * @return array|bool
     */
    protected function readStringFromTable($index, $table)
    {
        $sizeKey = $this->calcSizeKey($index);
        $size = $table[$sizeKey];

        if ($size > 0) {
            $offset = $table[$sizeKey + 1];
            fseek($this->file, $offset);
            return explode("\0", fread($this->file, $size));
        }

        return false;
    }

    /**
     * @param $counter
     *
     * @return mixed
     */
    protected function calcSizeKey($counter)
    {
        return $counter * 2 + 1;
    }

    /**
     * Prepare file for reading
     *
     * @param $filename
     *
     * @throws \Exception
     */
    protected function openFile($filename)
    {
        $this->filename = $filename;

        if (!is_file($this->filename)) {
            throw new \Exception(
                sprintf(
                    'File %s does not exist',
                    $this->filename
                )
            );
        }

        $this->file = fopen($this->filename, 'rb');
        if (false === $this->file) {
            throw new \Exception(
                sprintf(
                    'Could not open file %s for reading',
                    $this->filename
                )
            );
        }
    }

    /**
     * Determines byte order
     *
     * @throws \Exception
     */
    protected function determineByteOrder()
    {
        $orderHeader = fread($this->file, 4);

        if ($orderHeader == "\x95\x04\x12\xde") {
            $this->littleEndian = false;
        } elseif ($orderHeader == "\xde\x12\x04\x95") {
            $this->littleEndian = true;
        } else {
            fclose($this->file);
            throw new \Exception(
                sprintf(
                    '%s is not a valid gettext file',
                    $this->filename
                )
            );
        }
    }

    /**
     * Verify major revision (only 0 and 1 supported)
     *
     * @throws \Exception
     */
    protected function verifyMajorRevision()
    {
        $majorRevision = ($this->readInteger() >> 16);

        if ($majorRevision !== 0 && $majorRevision !== 1) {
            fclose($this->file);
            throw new \Exception(
                sprintf(
                    '%s has an unknown major revision',
                    $this->filename
                )
            );
        }
    }

    /**
     * Read a single integer from the current file.
     *
     * @return integer
     */
    protected function readInteger()
    {
        if ($this->littleEndian) {
            $result = unpack('Vint', fread($this->file, 4));
        } else {
            $result = unpack('Nint', fread($this->file, 4));
        }

        return $result['int'];
    }

    /**
     * Read an integer from the current file.
     *
     * @param  integer $num
     * @return integer
     */
    protected function readIntegerList($num)
    {
        if ($this->littleEndian) {
            return unpack('V' . $num, fread($this->file, 4 * $num));
        }

        return unpack('N' . $num, fread($this->file, 4 * $num));
    }
}
