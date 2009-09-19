<?php
class Holo_Request_ArrayObject_Exception extends Exception{};

class Holo_Request_ArrayObject extends ArrayObject
{
    const ERROR_REMOVE_ONRY = 1;
    const IGNORE_SNITIZE = 2;

    private $encoding;

    public function __construct($data, $encoding, $mode = 0)
    {
        $this->encoding = $encoding;
        if (($mode & self::ERROR_REMOVE_ONRY) === 0) {
            array_walk_recursive($data, array($this, 'checkInvalidEncoding'));           
        } else {
            $work = array();
            foreach ($data as $key => $value) {
                $result = $this->removeInvalidEncoding($key, $value);
                if (is_array($result)) {
                    $work[$result[0]] = $result[1]; 
                }
            }
            $data = $work;
        }

        if (($mode & self::IGNORE_SNITIZE) === 0) {
            $data = array_map(array($this, 'sanitizeNULL'), $data);
        }
        parent::__construct($data);
    }
    
    public function removeInvalidEncoding($key, $value)
    {
        if ($this->checkEncoding($key, '', $this->encoding) === false) {
            return false;
        }

        if (is_array($value)) {
            $result = array();
            foreach($value as $keydata => $value) {
                $valid = $this->removeInvalidEncoding($keydata, $value);
                if (is_array($valid)) {
                    $result[$valid['key']] = $valid['value'];
                }
            }
            return array($key, $result);
        }

        if ($this->checkEncoding($key, $value, $this->encoding) === false) {
            return false;
        }
        return array($key, $value);
    }

    public function checkInvalidEncoding($key, $value)
    {
        if ($this->checkEncoding($key, $value, $this->encoding) === false) {
            throw new Holo_Request_ArrayObject_Exception('invalid encoding');
        }
    }

    public function checkEncoding($key, $value, $encoding)
    {
        if (mb_check_encoding($key, $encoding) === false) {
            return false;
        }

        if (mb_check_encoding($value, $encoding) === false) {
            return false;
        }
    }

    public function sanitizeNull($data)
    {
        if (is_array($data)) {
            return array_map($data);
        }
        return str_replace("\0", '', $data);
    }
}

