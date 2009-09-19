<?php
//invalid encoding
$data = array('a', 'b', pack("C*", 0xC0, 0xAF));
try {
    $hra = new Holo_Request_ArrayObject($data, 'UTF-8');
} catch {
    var_dump($e->getMessage());
}

//invalid encoding remove
$hra = new Holo_Request_ArrayObject($data, 'UTF-8', Holo_Request_ArrayObject::ERROR_REMOVE_ONRY);
// array('a', 'b');
var_dump($hra);
