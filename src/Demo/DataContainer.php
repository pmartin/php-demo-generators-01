<?php
namespace Demo;

class DataContainer
{

    const SIZEOF_BYTE = 1;
    const SIZEOF_SHORT = 2;
    const SIZEOF_LONG = 4;


    /**
     * @var string
     */
    private $data;

    /**
     * @var int
     */
    private $pos;


    /**
     * @param string $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->pos = 0;
    }


    /**
     * @return string
     */
    public function getRawData()
    {
        return $this->data;
    }


    /**
     * @return int
     */
    public function length()
    {
        return strlen($this->data);
    }


    /**
     * @return int
     */
    public function readByte()
    {
        if ($this->pos > $this->length() - self::SIZEOF_BYTE) {
            throw new \OutOfBoundsException();
        }

        $result = unpack('C1', substr($this->data, $this->pos, self::SIZEOF_BYTE))[1];
        $this->pos += self::SIZEOF_BYTE;

        return $result;
    }


    /**
     * @return int
     */
    public function readShort()
    {
        if ($this->pos > $this->length() - self::SIZEOF_SHORT) {
            throw new \OutOfBoundsException();
        }

        $result = unpack('n1', substr($this->data, $this->pos, self::SIZEOF_SHORT))[1];
        $this->pos += self::SIZEOF_SHORT;

        return $result;
    }


    /**
     * @return int
     */
    public function readLong()
    {
        if ($this->pos > $this->length() - self::SIZEOF_LONG) {
            throw new \OutOfBoundsException();
        }

        $result = unpack('N1', substr($this->data, $this->pos, self::SIZEOF_LONG))[1];
        $this->pos += self::SIZEOF_LONG;

        return $result;
    }


    /**
     * @param int $size
     *
     * @return string
     */
    public function readBytes($size)
    {
        if ($this->pos > $this->length() - $size) {
            throw new \OutOfBoundsException();
        }

        $result = substr($this->data, $this->pos, $size);
        $this->pos += $size;

        return $result;
    }


    /**
     * @return string
     */
    public function readCString()
    {
        if ($this->pos > $this->length() - 1) {
            // At least one byte is required, for the end-of-string marker
            throw new \OutOfBoundsException();
        }

        $endOfString = strpos($this->data, "\x00", $this->pos);
        if ($endOfString === false) {
            // No end-of-string marker has been found
            throw new \UnexpectedValueException();
        }

        $result = substr($this->data, $this->pos, $endOfString - $this->pos);
        $this->pos += ($endOfString - $this->pos) + 1;

        return $result;
    }


    /**
     * @return string[]
     */
    public function readArrayOfCStrings()
    {
        if ($this->pos > $this->length() - 2) {
            // At least two bytes are required, for the end-of-array marker
            throw new \OutOfBoundsException();
        }

        $endOfArray = strpos($this->data, "\x00\x00", $this->pos);
        if ($endOfArray === false) {
            // No end-of-array marker has been found
            throw new \UnexpectedValueException();
        }

        $unfilteredResult = explode("\x00", substr($this->data, $this->pos, $endOfArray - $this->pos));

        $this->pos += ($endOfArray - $this->pos) + 1 + 1;

        return array_filter($unfilteredResult);
    }


    /**
     * @param int  $numberOfStrings
     * @param bool $acceptLessStrings
     *
     * @return \string[]
     */
    public function readFixedSizeArrayOfCStrings($numberOfStrings, $acceptLessStrings = false)
    {
        $result = [ ];

        try {
            for ($i = 0; $i < $numberOfStrings; $i++) {
                $result[] = $this->readCString();
            }
        }
        catch (\OutOfBoundsException $e) {
            if (false === $acceptLessStrings) {
                throw $e;
            }
        }

        return $result;
    }


    /**
     * @return string
     */
    public function readUntilEnd()
    {
        if ($this->isEndOfData()) {
            return '';
        }

        $result = substr($this->data, $this->pos);
        $this->pos = $this->length();

        return $result;
    }


    /**
     * @param int $offset
     *
     * @return int
     */
    public function seek($offset)
    {
        if ($this->pos + $offset < 0) {
            throw new \OutOfBoundsException("Cannot seek to a negative index");
        }
        if ($this->pos + $offset > $this->length()) {
            throw new \OutOfBoundsException("Cannot seek outside of the data");
        }

        $this->pos += $offset;

        return $this->tell();
    }


    /**
     * @return int
     */
    public function tell()
    {
        return $this->pos;
    }


    /**
     * @return bool
     */
    public function isEndOfData()
    {
        return $this->pos >= $this->length();
    }

}